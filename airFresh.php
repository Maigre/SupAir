<?php 


//TODO : Before MySQL DUMP : count -1 histo and number of tickets to know if a dump is necessary / force if Files Freshed FTP

//TODO : ProgressBar for histo transmission ?


//Integrity test
//KEEP THIS PART WHATEVER UPGRADES ARE PERFORMED HERE
if (isset($_GET['test']))
if ($_GET['test'] == 1) 
{
	//PERFORM ALL TEST TO BE SURE THE FILE WILL BE INCLUDED WITHOUT BLOCKING ERROR !
	echo "I'm All Right !";
	die;
}
/********************************************************/

if (!defined('AIRBRAIN_VERSION')) die;

//READ ONLY FTP ACCESS CONFIGURATION
define('FTP_HOST','ftp.airlab.fr');
define('FTP_USER','soluble.SupAir');
define('FTP_PASS','pass_ftp37');

define('VERSION_SERVER_FILE','server.alv');


//MAIN CONTROLLER STARTED BY AIRBRAIN
function AirFresh($config)
{
	//push local sql historique to server 
	PushMySQL($config);
	
	if (!$config['mysql_only'])
	{
		//FTP connection
		$config['ftp']['host'] = FTP_HOST;
		$config['ftp']['user'] = FTP_USER;
		$config['ftp']['pass'] = FTP_PASS;
	
		$ftp = new FTPclass($config['ftp']);
		if (!$ftp->connect()) sorry(NO_CONNECTION);
		
		//DELETE local version file
		@unlink($config['local_version_file']);

		FreshFiles($ftp,$config);
	}
	
	//start sql dump
	FreshMySQL($config);
	
	//GET NEW VERSION
	echo '<br />version validation..';
	
		$new_version = trim(@file_get_contents($config['ftp']['local_path'].VERSION_SERVER_FILE));
		if ($new_version == '') sorry('warning: new version not installed properly, upgrade failed..');
		
		//CREATE THE NEW LOCAL VERSION FILE
		else @file_put_contents($config['local_version_file'],$new_version);
	
	echo ' [ok]';
	
	//end
	return TRUE;
}

function FreshFiles($ftp,$config)
{
	echo '<br />software update.....';
	//CHECK FTP CONNECTION 	
	if (!$ftp->connected()) sorry(NO_CONNECTION);
	else
	{
		//START SYNC APPLICATION
		if(!$ftp->mirror_download($config['ftp']['remote_path'], $config['ftp']['local_path'])) sorry('files: errors during synchronisation..');		
	}
	echo ' [ok]';
}

function FreshMySQL($config)
{
	echo '<br />download dump.......';
		
		$dumpfile_gz = $config['ftp']['local_path'].'dump.sql.gz';
				
		$ask = http_post($config['airTraffic_url'],array('action'=>'dump','airlab_key'=>AIRLAB_KEY));

		if ($ask['content'] != '') @file_put_contents($dumpfile_gz,$ask['content']);
		else sorry('http: impossible to get dump from the server..');
	
	echo ' [ok]';
	
	echo '<br />database import.....';
		
		$dumpfile = str_replace('.sql.gz','.sql',$dumpfile_gz);
		@unlink($dumpfile);
		
		system('gunzip '.$dumpfile);
		
		//DELETE VERSION FILE
		@unlink($config['local_version_file']);
		
		system('mysql -h '.MYSQL_HOST.' -u '.MYSQL_USER.' -p'.MYSQL_PASS.' '.MYSQL_BASE.' < '.$dumpfile,$err);	
		if ($err) sorry('mysql: import failed !');
		
	echo ' [ok]';

}

function PushMySQL($config)
{

	echo '<br />sync histo state....';
		
	$my = new myDriver();
	if (!$my) sorry('local: impossible to connect local database !');
	
	//SYNCHRONISE TICKETS STATE WITH SERVER
	//confirm state for tickets with statut 1 and 2
		syncTicketState($my,$config);
		
	echo ' [ok]';	
	
	
	//CHECKING STATE 0 histo
	//STATE 0 : queries unknow on the server, need to open a new ticket
		$c = $my->QueryM("SELECT * FROM `historique` WHERE `ticket` = 0 ORDER BY `id`");
		if (is_array($c[0]))
		{
			echo '<br />opening new ticket..';	
			//ASK SERVER FOR A NEW TICKET
				$ask = http_post($config['airTraffic_url'],array('action'=>'new_ticket','airlab_key'=>AIRLAB_KEY));
				if (!($ask['content'] != '')) sorry('server: impossible to get a new ticket'); 
				else 
				{
					if (is_numeric($ask['content']))
					{
						//save new ticket
						$my->Query("INSERT INTO `historique_tickets` VALUES ('".$ask['content']."','".AIRLAB_KEY."','1')");
						
						//link ticket to open histo
						$my->Query("UPDATE `historique` SET `ticket` = '".$ask['content']."' WHERE `ticket` = '0'");
					}
					else sorry('wrong answer from server');
				}
				
				syncTicketState($my,$config);
							
			echo ' [ok]';
		}
		
	//CHECKING STATE 1 histo
	//STATE 1 : ticket attributed by the server but transfer havn't been completed'
		$c = $my->QueryM("SELECT * FROM `historique_tickets` WHERE `statut` = 1 ORDER BY `id`");
		if (is_array($c[0]))
		{
			foreach($c as $tik)
			{				
				echo '<br />push ticket '.$tik['id'].'......';
			
					//GET ALL HISTO FOR THIS TICKET
					$histos = $my->QueryM("SELECT * FROM `historique` WHERE `ticket` = '".$tik['id']."' ORDER BY `id`");
					
					if (is_array($histos[0]))
					{
						//POST ALL HISTO ENTRIES CONCERNED BY 
						$post = json_encode($histos);
						$hash = md5($post);
						$post = gzcompress($post,9);
						
						$ask = http_post($config['airTraffic_url'],array('action'=>'push_histo','ticket'=>$tik['id'],'histos'=>$post,'hash'=> $hash,'airlab_key'=>AIRLAB_KEY));
						
						//SERVER WILL SET THE TICKET ON STATE 2 IF RECIEVED, AND REPLY SOMETHING LIKE 'ok'
						if ($ask['content'] == '') sorry('histo transfer failed for ticket '.$tik['id']);
						else if ($ask['content'] == 'bad_ticket') sorry('ticket '.$tik['id'].' bad number.. please re-start sync ');
						else if ($ask['content'] == 'wrong_hash') sorry('ticket '.$tik['id'].' bad hash.. please re-start sync ');
						else if ($ask['content'] == 'no_ticket') sorry('ticket '.$tik['id'].' lost.. please re-start sync ');
					}
					//if no histo : delete ticket
					else $my->Query("DELETE FROM `historique_tickets` WHERE `id` = '".$tik['id']."'");
										
				echo ' [ok]';
			}
			
			syncTicketState($my,$config);
		}		
		
	//CHECKING STATE 2 histo
	//STATE 2 : queries recieved by the server.. ask server if queries have been executed ?
		$c = $my->QueryM("SELECT * FROM `historique_tickets` WHERE `statut` = 2");
		if (is_array($c[0]))
		{
			echo '<br />server runs queries..';
				
				//COMMAND SERVER TO EXECUTE PENDING HISTO
				$ask = http_post($config['airTraffic_url'],array('action'=>'run_histo','airlab_key'=>AIRLAB_KEY));			

				syncTicketState($my,$config);
			
			echo '[ok]';
		}
		
	//FINAL RE-CHECK, IF THERE IS STILL HISTO OR OPEN TICKETS -> STOP, WE CAN'T DUMP MYSQL SERVER UNTIL EVERYTHING IS FINE HERE !
		$c = $my->QueryM("SELECT * FROM `historique` WHERE `ticket` = 0 ORDER BY `id`");
		if (is_array($c[0])) sorry('stop: there is still some ticket-less histo entries.. please restart sync or contact your admin');
		
		$c = $my->QueryM("SELECT * FROM `historique_tickets` WHERE `statut` = 1 ORDER BY `id`");
		if (is_array($c[0])) sorry('stop: there is still some tickets with state 1.. please restart sync or contact your admin');
	
		$c = $my->QueryM("SELECT * FROM `historique_tickets` WHERE `statut` = 2");
		if (is_array($c[0])) sorry('stop: there is still some tickets with state 2.. please restart sync or contact your admin');
		
		//echo '<br />synchronisation..... [ok]';
		
	$my->close();
}


function syncTicketState($my,$config)
{	
	//TODO : GARABGE COLLECTOR FOR HISTO WITH >= 0 UNKNOWN TICKET
	
	$c = $my->QueryM("SELECT * FROM `historique_tickets` WHERE (`statut` = 1 OR `statut` = 2) AND `key` = '".AIRLAB_KEY."'");

	if (count($c) > 0)
	{
		//ASK SERVER THE STATE OF THOSE TICKETS
		foreach($c as $tik) $tiks[$tik['id']] = $tik['statut'];
		
		$ask = http_post($config['airTraffic_url'],array('action'=>'histo_state','tickets'=>json_encode($tiks),'airlab_key'=>AIRLAB_KEY));
		
		if (trim($ask['content']) == '') sorry(NO_CONNECTION);
		
		$res = json_decode($ask['content'],TRUE);
		
		//IF SERVER STATE IS HIGHER : APPLY ON LOCAL TICKET
		if (is_array($res))
		foreach ($tiks as $id=>$tik)
		{
			if ($tik['statut'] < $res[$id]) 
				if (is_numeric($res[$id])) $my->Query("UPDATE `historique_tickets` SET  `statut` = '".$res[$id]."' WHERE `id` = '".$id."'");
			
			if ($res[$id] == 'unknown') 
			{
				$my->Query("DELETE FROM `historique_tickets` WHERE `id` = '".$id."'");
				$my->Query("UPDATE `historique` SET `ticket` = '0' WHERE `ticket` = '".$id."')");
			}
		}
	}
}


class myDriver
{
	var $link;
	
	function __construct()
	{
		$this->link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		if (!$this->link) sorry('mysql: unable to connect local db');

		mysql_select_db(MYSQL_BASE,$this->link);
	}
	
	function Query($query)
	{
		$q = mysql_query($query,$this->link);
		return $q;
	}
	
	function Query1($query,$field=false)
	{
		$data = $this->QueryM($query);
		
		if ($field) return $data[0][$field];
		return $data[0];
	}
	
	function QueryM($query)
	{
		$q = $this->Query($query);
		
		while ($row = mysql_fetch_assoc($q)) $data[] = $row;
		mysql_free_result($q);
		
		return $data;
	}
	
	function close()
	{
		mysql_close($this->link);
	}
}




/**
	FTP CLASS

	MODDED BY MGR

		COPOSITE CLASS FROM 
		- FTP CODEIGNITER CLASS
		- www.chirp.com.au FTP LISTING FUNCTIONS 
		- AirLab customisation

		**/

		// ------------------------------------------------------------------------

		/**
		 * FTP Class
		 *
		 * @package		CodeIgniter
		 * @subpackage	Libraries
		 * @category	Libraries
		 * @author		ExpressionEngine Dev Team
		 * @link		http://codeigniter.com/user_guide/libraries/ftp.html
		 */
		 
		 
		class FTPclass {

			var $host	= '';
			var $user	= '';
			var $pass	= '';
			var $port		= 21;
			var $ssl		= TRUE;
			var $passive	= TRUE;
			var $debug		= FALSE;
			var $conn_id	= FALSE;
			var $overwrite_only_different = TRUE; //TRUE overwrite file only if different, if identical skip //FALSE force overwrite everytime


			/**
			 * Constructor - Sets Preferences
			 *
			 * The constructor can be passed an array of config values
			 */
			public function __construct($config = array())
			{
				if (count($config) > 0)
				{
					$this->initialize($config);
				}

				//log_message('debug', "FTP Class Initialized");
			}

			// --------------------------------------------------------------------

			/**
			 * Initialize preferences
			 *
			 * @access	public
			 * @param	array
			 * @return	void
			 */
			function initialize($config = array())
			{
				foreach ($config as $key => $val)
				{
					if (isset($this->$key))
					{
						$this->$key = $val;
					}
				}

				// Prep the host
				$this->host = preg_replace('|.+?://|', '', $this->host);
			}

			// --------------------------------------------------------------------

			/**
			 * FTP Connect
			 *
			 * @access	public
			 * @param	array	 the connection values
			 * @return	bool
			 */
			function connect($config = array())
			{
				if (count($config) > 0)
				{
					$this->initialize($config);
				}

				if ($this->ssl) $this->conn_id = @ftp_ssl_connect($this->host, $this->port);
				else $this->conn_id = @ftp_connect($this->host, $this->port);

				if (FALSE === $this->conn_id)
				{
					if ($this->debug == TRUE)
					{
						$this->_error('ftp_unable_to_connect');
					}
					return FALSE;
				}

				if ( ! $this->_login())
				{
					if ($this->debug == TRUE)
					{
						$this->_error('ftp_unable_to_login');
					}
					return FALSE;
				}

				// Set passive mode if needed
				if ($this->passive == TRUE)
				{
					ftp_pasv($this->conn_id, TRUE);
				}

				return TRUE;
			}

			// --------------------------------------------------------------------

			/**
			 * FTP Login
			 *
			 * @access	private
			 * @return	bool
			 */
			function _login()
			{
				return @ftp_login($this->conn_id, $this->user, $this->pass);
			}

			// --------------------------------------------------------------------

			/**
			 * Validates the connection ID
			 *
			 * @access	public
			 * @return	bool
			 */
			function connected()
			{
				if ( ! is_resource($this->conn_id))
				{
					if ($this->debug == TRUE)
					{
						$this->_error('ftp_no_connection');
					}
					return FALSE;
				}
				return TRUE;
			}

			// --------------------------------------------------------------------


			/**
			 * Change directory
			 *
			 * The second parameter lets us momentarily turn off debugging so that
			 * this function can be used to test for the existence of a folder
			 * without throwing an error.  There's no FTP equivalent to is_dir()
			 * so we do it by trying to change to a particular directory.
			 * Internally, this parameter is only used by the "mirror" function below.
			 *
			 * @access	public
			 * @param	string
			 * @param	bool
			 * @return	bool
			 */
			function changedir($path = '', $supress_debug = FALSE)
			{
				if ($path == '' OR ! $this->connected())
				{
					return FALSE;
				}

				$result = @ftp_chdir($this->conn_id, $path);

				if ($result === FALSE)
				{
					if ($this->debug == TRUE AND $supress_debug == FALSE)
					{
						$this->_error('ftp_unable_to_changedir');
					}
					return FALSE;
				}

				return TRUE;
			}


			// --------------------------------------------------------------------

			/**
			 * Download a file from a remote server to the local server
			 *
			 * @access	public
			 * @param	string
			 * @param	string
			 * @param	string
			 * @return	bool
			 */
			function download($rempath, $locpath, $remote_file = NULL, $mode = 'auto')
			{
				if ($this->debug) $start = microtime(true);
				if ( ! $this->connected())
				{
					return FALSE;
				}

				// Set the mode if not specified
				if ($mode == 'auto')
				{
					// Get the file extension so we can set the upload type
					$ext = $this->_getext($rempath);
					$mode = $this->_settype($ext);
				}

				$mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;		
		
				//IF OVERWRITE DIFFERENT ONLY 
				//Test if file exist and compare date and size		
				if (($this->overwrite_only_different) and ($this->_compare($locpath,$rempath,$remote_file))) 
				{
					//if ($this->debug) echo '<br />skip '.$rempath; 
					$result = TRUE;
				}
				else 
				{
					$result = ftp_get($this->conn_id, $locpath, $rempath, $mode); //Proceed the download
					if ($this->debug) 
					{
						if ($result === FALSE) echo '<br />error '.$rempath; 
						else echo '<br />downloaded '.$rempath; 
						$echo_time = true;
					}
				}
		
				if (($result !== FALSE)&&($remote_file['date']>0)) touch($locpath,$remote_file['date']);

				// Set file permissions if needed
				if ( isset($remote_file['chown']))
				{
				    chmod($locpath, (int)$permissions);
				}

				if ($echo_time) echo ' ('.(round((microtime(true)-$start)*1000)/1000).' s)'; 
				return $result;
			}
	
			/* COMPARE DATE AND SIZE OF BOTH FILES*/
			/* RETURN TRUE IF IDENTICAL, FALSE ELSE */
			function _compare($locpath,$rempath,&$remote_file)
			{		
				//if(true)
				if (!is_array($remote_file))
				{
					$remote_file['size'] = @ftp_size($this->conn_id,$rempath);
					$remote_file['date'] = @ftp_mdtm($this->conn_id,$rempath);
					if ($this->debug) echo '<br />ask date & time'; 
				}
		
				$size_local = @filesize($locpath);
				$date_local = @filemtime($locpath);

				//if (($size_remote == $size_local) and ($date_local == $date_remote)) echo '<BR />same';
				//else echo '<BR />different: '.$date_remote.' '.$date_local;

				$ok = true;

				if ($remote_file['size'] != $size_local) 
				{
					//echo '<br />size doesn\'t macth :';
					$ok = false;
				}
		
				if ($date_local != $remote_file['date'])
				{
					//echo '<br />date doesn\'t macth';
					$ok = false;
				}
		
				return $ok;
			}



			// --------------------------------------------------------------------

			/**
			 * Set file permissions
			 *
			 * @access	public
			 * @param	string	the file path
			 * @param	string	the permissions
			 * @return	bool
			 */
			function chmod($path, $perm)
			{
				if ( ! $this->connected())
				{
					return FALSE;
				}

				// Permissions can only be set when running PHP 5
				if ( ! function_exists('ftp_chmod'))
				{
					if ($this->debug == TRUE)
					{
						$this->_error('ftp_unable_to_chmod');
					}
					return FALSE;
				}

				$result = @ftp_chmod($this->conn_id, $perm, $path);

				if ($result === FALSE)
				{
					if ($this->debug == TRUE)
					{
						$this->_error('ftp_unable_to_chmod');
					}
					return FALSE;
				}

				return TRUE;
			}

	
			function mirror_download($rempath, $locpath, $file_list = NULL)  //rempath : remote source //locpath : local destination
			{
				//file list to know dates and sizes for every files on the server !     	
				if (!is_array($file_list)) 
				{
					$file_list = $this->_ftp_list($rempath,true);			
					$this->Init_ProgressBar($file_list['total_size']);
				}
				
				$result = TRUE;
				
				if ( ! $this->connected()) return FALSE;
		
				// Attempt to open the local file path.
				if ( ! is_dir($locpath))
				{
				    if ( ! mkdir($locpath) )
				    {
				       $this->_error('mirror local: impossible to make dir !');
				    }
				}
		
				// Open the remote file path
				if ($this->changedir($rempath, TRUE))
				{
				    // Attempt to open the local file path.
				    if ( ! is_dir($locpath))
				    {
				        if ( ! mkdir($locpath) )
				        {
				           $this->_error('mirror local: impossible to make dir !');
				        }
				    }
			
					if (is_array($file_list))
					foreach($file_list as $i=>$file)
					{
						if (is_numeric($i))
						{
							if ($file['isDir']) 
							{	
								if (is_array($file['children']))
									$res = $this->mirror_download($rempath.$file['name']."/", $locpath.$file['name']."/", $file['children']);
								else $res = true;
							}
							else 
								$res = $this->download($rempath.$file['name'], $locpath.$file['name'], $file);
					
							$this->ProgressBar($file['size']);
					
							$result = $res and $result;
						}
					}
			
				    return $result;
				}

				return TRUE;
			}


			function Init_ProgressBar($max_value,$gauche= 0,$haut= 4,$largeur = 100,$hauteur=12,$bord_col='black',$txt_col='black',$bg_col='#CCC',$prog_col='white')
			{
				
				global $bar;
				
				if ($bar > 0)
				{
					if ($max_value > 0) 
					{
						echo "\n<script>max_value = max_value+".$max_value."</script>";
						$this->ProgressBar(0);
					}
				}
				else
				{
					$bar = 1;
					//texte
					$tailletxt=$hauteur-10;
					echo '<div id="pourcentage" style="position:relative;top:'.($haut);
					echo ';left:'.$gauche;
					echo ';width:'.$largeur.'px';
					echo ';height:'.$hauteur.'px;border:1px solid '.$bord_col.';font-weight:bold';
					echo ';color:'.$txt_col.';z-index:1;text-align:center;">0%</div>';
					//fond noir
					echo '<div id="backside" style="position:relative;top:'.($haut-13); //+1
					echo ';left:'.($gauche+1); //+1
					echo ';width:100px';
					echo ';height:'.$hauteur.'px';
					echo ';background-color:'.$prog_col.';z-index:0;"></div>';
					//progress bar
					echo '<div id="progrbar" style="position:relative;top:'.($haut-25); //+1
					echo ';left:'.($gauche+1); //+1
					echo ';width:0px';
					echo ';height:'.$hauteur.'px';
					echo ';background-color:'.$bg_col.';z-index:0;"></div>';
		
					echo "\n<script>var max_value = ".$max_value."; var current_value=0;</script>";
				}
			}
	
			function ProgressBar($value)
			{
				echo "\n<script>";
				echo "\ncurrent_value = current_value+".$value.";";
				echo "\nif (current_value >= max_value) {";
				echo "\ndocument.getElementById(\"pourcentage\").style.display = 'none';";
				echo "\ndocument.getElementById(\"progrbar\").style.display = 'none';";
				echo "\ndocument.getElementById(\"backside\").style.display = 'none';";
				echo "\n} else {";
				echo "\ndocument.getElementById(\"pourcentage\").innerHTML= Math.floor(current_value*100*100/max_value)/100 + '%';";
				echo "\ndocument.getElementById('progrbar').style.width= (current_value*100/max_value);\n";
				echo "\n}";
				echo "\n</script>";
				ob_flush();
				flush(); // explication : http://www.manuelphp.com/php/function.flush.php
			}

			// --------------------------------------------------------------------

			function _getmode($filename)
			{
				return $this->_settype($this->_getext($filename));
			}


			/**
			 * Extract the file extension
			 *
			 * @access	private
			 * @param	string
			 * @return	string
			 */
			function _getext($filename)
			{
				if (FALSE === strpos($filename, '.'))
				{
					return 'txt';
				}

				$x = explode('.', $filename);
				return end($x);
			}


			// --------------------------------------------------------------------

			/**
			 * Set the upload type
			 *
			 * @access	private
			 * @param	string
			 * @return	string
			 */
			function _settype($ext)
			{
				$text_types = array(
									'txt',
									'text',
									'php',
									'phps',
									'php4',
									'js',
									'css',
									'htm',
									'html',
									'phtml',
									'shtml',
									'log',
									'xml'
									);


				return (in_array($ext, $text_types)) ? 'ascii' : 'binary';
			}

			// ------------------------------------------------------------------------

			/**
			 * Close the connection
			 *
			 * @access	public
			 * @param	string	path to source
			 * @param	string	path to destination
			 * @return	bool
			 */
			function close()
			{
				if ( ! $this->connected())
				{
					return FALSE;
				}

				@ftp_close($this->conn_id);
			}

			// ------------------------------------------------------------------------

			/**
			 * Display error message
			 *
			 * @access	private
			 * @param	string
			 * @return	bool
			 */
			function _error($line)
			{
				//TODO : mail error 
		
				echo $line."<br />";
			}
	
			// lister FTP
			// Original PHP code by Chirp Internet: www.chirp.com.au 
			// Please acknowledge use of this code by including this header. 
			function _ftp_list($dir,$recurse=true)
			{	
				@ftp_chdir($this->conn_id, $dir); 
				$rawfiles = @ftp_rawlist($this->conn_id, $dir, $recurse);
	
				// here the magic begins!
				$structure = array();
				$arraypointer = &$structure;
				$total_size = 0;
				foreach ($rawfiles as $rawfile) 
				{
					if ($rawfile[0] == '/') 
					{
						$paths = array_slice(explode('/', str_replace(':', '', $rawfile)), 1);
						$arraypointer = &$structure;
						foreach ($paths as $path) {
							foreach ($arraypointer as $i => $file) {
								if ($file['name'] == $path) {
								    $arraypointer = &$arraypointer[ $i ]['children'];
								    break;
								}
							}
						}
					} 
					elseif(!empty($rawfile)) 
					{
						$info = preg_split("/[\s]+/", $rawfile, 9);       
				
						if (is_numeric($info[7])) $info[9] = '00:00';
						else
						{
							$info[9] = $info[7];
							$info[7] = date('Y');
							if (strtotime($info[6] . ' ' . $info[5] . ' ' . $info[7] . ' ' . $info[9]) > time()) $info[7]--;
						}
				
						$arraypointer[] = array(
							'name'   => $info[8],
							'isDir'  => $info[0]{0} == 'd',
							'size'   => $info[4],
							'chmod'  => $this->chmodnum($info[0]),
							'date'   => strtotime($info[6] . ' ' . $info[5] . ' ' . $info[7] . ' ' . $info[9]),
							'raw'    => $info
							// the 'children' attribut is automatically added if the folder contains at least one file
							);
					
						$total_size += $info[4];
					}
				}

				// in $structure is all the data
				$structure['total_size'] = $total_size;
				return $structure;

			}

			function chmodnum($chmod) 
			{
				$trans = array('-' => '0', 'r' => '4', 'w' => '2', 'x' => '1');
				$chmod = substr(strtr($chmod, $trans), 1);
				$array = str_split($chmod, 3);
				return array_sum(str_split($array[0])) . array_sum(str_split($array[1])) . array_sum(str_split($array[2]));
			}

		}
		// END FTP Class

?>
