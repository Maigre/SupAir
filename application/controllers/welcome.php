<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{
	/*
		$this->db->order_by('id');
		$query = $this->db->get('historique');
		
		$histo = $query->result();
		
		echo 'AVANT :<br />';
		foreach ($histo as $h)
		{
			echo str_replace("\n"," ",$h->requete).'<br />';
		}

		//TRANSFORM
		
		$imax = count($histo);
		for ($i = 0; $i < $imax; $i++)
		{
			$parse = histo_parse($histo[$i]->requete);
			if ($parse['type'] == 'INSERT')
			{
				for ($j = ($i+1); $j < $imax; $j++)
				{
					$sub_parse = histo_parse($histo[$j]->requete);
					histo_changeID($sub_parse,$parse['table'],$histo[$i]->insert_id,82);
					$histo[$j]->requete = histo_unparse($sub_parse);
				}
			}
		}
		
		
		echo '<br />APRES :<br />';
		foreach ($histo as $h)
		{
			echo str_replace("\n"," ",$h->requete).'<br />';
		}
		*/
		$this->load->view('mainview');
	}
}

/*


zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr


*/

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
