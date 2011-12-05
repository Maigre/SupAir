<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Exercice extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'exercice';
		$this->type = 'exercice';
	}
	
	function prepareNew()
	{
		//TODO return new exercice info based on last created one
		$array['nom'] = "2011 - 2012";
		$array['debut'] = "01/09/2011";
		$array['fin'] = "31/08/2012";
	}
}
