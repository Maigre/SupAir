<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Periode extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'exercice';
		$this->type = 'periode';
	}
}