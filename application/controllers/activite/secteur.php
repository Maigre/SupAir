<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Secteur extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'activite';
		$this->type = 'Secteur';
	}
}
