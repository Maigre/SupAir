<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{

		//Charger ici toutes les classes de Extjs contenues dans le dossier application/views de CodeIgniter
		
		
		$data['views'][]=$this->load->view('Application',null,true);
		$data['views'][]=$this->load->view('menu',null,true);
		$data['views'][]=$this->load->view('searchBar',null,true);
		$data['views'][]=$this->load->view('adherentDisplay',null,true);
		$data['views'][]=$this->load->view('adherentForm',null,true);
		$data['views'][]=$this->load->view('enfantForm',null,true);
		$data['views'][]=$this->load->view('familleDisplay',null,true);
		$data['views'][]=$this->load->view('familleForm',null,true);
		$data['views'][]=$this->load->view('nouvelleFamilleForm',null,true);
		$data['views'][]=$this->load->view('adherentMain',null,true);
	//***TOOLS
		$data['views'][]=$this->load->view('tools/ListWindow',null,true);	
		

	//***CALENDAR
		

		
		$data['views'][]=$this->load->view('calendrierWindow',null,true);
		
		$data['views'][]=$this->load->view('activiteForm',null,true);
		
		
		$this->load->view('mainview',$data);
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
