<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{
		
		
		
		var_dump($this);
		$this->load->view('mainview');
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
