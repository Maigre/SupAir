<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Famille extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		require_once(APPPATH.'models/famille_m.php');
	}
	
	function show($id=false)
	{
		$Famille = new Famille_m($id);
		echo json_encode($Famille->show());
	}
	
	function edit($id=false)
	{
		$Famille = new Famille_m($id);
		echo json_encode($Famille->edit());
	}
}
