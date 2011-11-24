<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Calendrier extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'exercice';
		$this->type = 'calendrier';
	}
	
	function save(){
		$results = json_decode($this->input->post());
		$answer['data']=$results;
		$answer['success']=true;
		echo json_encode($answer);
		die;
	}
}
