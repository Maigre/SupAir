<?php

define('DB_STYLE','Datamapper');

include_once("SQLparsecompile/config.inc.php");

/*RECORD QUERIES AS HISTORIQUE
**
*/

function record_query($driver,$sql)
{
	//On écrit la requête dans la table historique des requêtes.
	//on vérifie que la requête correspond bien à une modification de la database (i.e la requête commence par INSERT, UPDATE ou DELETE)
	$histo_id = false;

	//check query type
	$type = strtolower(substr(trim($sql),0,6));

	if (($type == 'insert') or ($type == 'update') or ($type == 'delete')) 
	{
		//prepare for embarrassing characters
		$sql = str_replace("\n"," ",$sql);
		$sql = str_replace("\'","*",$sql);
		
		//parse the request to get details
		$parse = histo_parse($sql);

		//successful PARSE
		if (is_array($parse))
		{
			if ($parse['TableNames'][0] != '`system_sessions`')
			{
				if (APP_TYPE == 'server') $ticket = -1;
				else $ticket = 0;
		
				$requete= "INSERT INTO `historique` VALUES (null,\"".$sql."\",'".now()."','".$parse['Command']."',\"".$parse['TableNames'][0]."\",null,\"".$ticket."\",0,null)";
				$driver->simple_query($requete);
		
				if ($parse['Command'] == 'insert') $histo_id = $driver->insert_id();
			}
		}
		//failed PARSE
		else
		{
			$requete= "INSERT INTO `historique` VALUES (null,\"".$sql."\",\"".now()."\",null,null,null,1,null)";
			$driver->simple_query($requete);
		}
	}		
	
	return $histo_id;
}

function record_query_id($driver,$histo_id,$insert_id)
{
	if ($histo_id > 0) $driver->simple_query("UPDATE `historique` SET `insert_id` = ".$insert_id." WHERE `id` = ".$histo_id);		
}


function histo_parse($sql)
{
	$sqlObject = new Sql_Parser($sql);
	return  $sqlObject->parse();
}



/*REVERSE HISTORIQUE
**
*/


function histo_unparse($parsedSQL)
{
	$sqlObject2 = new Sql_Compiler();
	return $sqlObject2->compile($parsedSQL);
}

//CHANGE NEXT HISTO DEPENDING ON NEW ID OBTAINED WITH INSERT
function histo_changeID(&$parse,$insert_table,$old_id,$new_id)
{
	$insert_table = str_replace("`","",$insert_table);
	
	if (($parse['Command'] == "insert") and ($parse['TableNames'][0] != $insert_table))
	{
		if (DB_STYLE == 'Datamapper') $field_search = '`'.substr($insert_table,0,-1).'_id`';  //Datamapper style
		else if (DB_STYLE == 'Gwikid') $field_search = '`id'.$insert_table.'`';					 //Gwikid style

		
		foreach($parse['ColumnNames'] as $id => $name)
				if (($name == $field_search) && ($parse['Values'][0][$id]['Value'] == $old_id)) $parse['Values'][0][$id]['Value'] = $new_id;
	}
	
	
	if (($parse['Command'] == "update") or ($parse['type'] == "delete"))
	{
		if (DB_STYLE == 'Datamapper')
		{
			if ($parse['TableNames'][0] != $insert_table) $field_search = '`'.substr($insert_table,0,-1).'_id`';	//Datamapper style
			else $field_search = '`id`';																			//Datamapper style
		}
		else if (DB_STYLE == 'Gwikid') $field_search = '`id'.$insert_table.'`';										//Gwikid style

		
		
		//SEARCH IN SETS
		if ($parse['Command'] == "update")					
			foreach($parse['ColumnNames'] as $id => $name)
				if (($name == $field_search) && ($parse['Values'][$id]['Value'] == $old_id)) $parse['Values'][$id]['Value'] = $new_id;
			
		//SEARCH IN WHERE'S
		if (is_array($parse['Where'])) iterativeDigger($parse['Where'],0,$field_search,$old_id,$new_id);
	}
}

//ITERATIVE SEARCH IN WHERE'S
function iterativeDigger(&$entry,$depth,$field_search,$old_id,$new_id)
{
	$max_depth = 10;

	if (isset($entry['Left']['Value']))
	{	
		if (($entry['Left']['Value'] == $field_search) && ($entry['Right']['Value'] == $old_id)) 
																					$entry['Right']['Value'] = $new_id;
	}
	else if ($depth < $max_depth)
	{
		if (isset($entry['Left']['Left'])) iterativeDigger($entry['Left'],($depth+1),$field_search,$old_id,$new_id);
		if (isset($entry['Right']['Left'])) iterativeDigger($entry['Right'],($depth+1),$field_search,$old_id,$new_id);
	}
}













