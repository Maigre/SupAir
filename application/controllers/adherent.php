<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adherent extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		require_once(APPPATH.'models/adherent_m.php');
	}
	
	function show($id=false)
	{
		$Adherent = new Adherent_m($id);
		echo json_encode($Adherent->show());
	}
	
	function edit($id=false)
	{
		$Adherent = new Adherent_m($id);
		echo json_encode($Adherent->edit());
	}
}
