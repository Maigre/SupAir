<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{

		//Charger ici toutes les classes de Extjs contenues dans le dossier application/views de CodeIgniter
		
		//main application
		$data['views'][]=$this->load->view('Application',null,true);
		
		//auto generate class from style images
		$data['styles'][]=$this->load->view('iconCls',array('img_list' => get_dir_file_info('style/',false)),true);
		
		//viewport
		$data['extjs'][]=$this->load->view('menu',null,true);
		$data['extjs'][]=$this->load->view('searchBar',null,true);
		
		//users
		$data['extjs'][]=$this->load->view('adherentDisplay',null,true);
		$data['extjs'][]=$this->load->view('adherentForm',null,true);
		$data['extjs'][]=$this->load->view('enfantForm',null,true);
		$data['extjs'][]=$this->load->view('familleDisplay',null,true);
		$data['extjs'][]=$this->load->view('familleForm',null,true);
		$data['extjs'][]=$this->load->view('nouvelleFamilleForm',null,true);
		$data['extjs'][]=$this->load->view('adherentMain',null,true);
	
	
	//***TOOLS
		$data['extjs'][]=$this->load->view('tools/ListWindow',null,true);	
		

	//***CALENDAR
		

		
		$data['extjs'][]=$this->load->view('calendrierWindow',null,true);
		
		$data['extjs'][]=$this->load->view('activiteForm',null,true);
		$data['extjs'][]=$this->load->view('secteurForm',null,true);
		
		
		$this->load->view('mainview',$data);
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
