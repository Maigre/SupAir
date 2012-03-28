<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Animateur extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'personnel';
		$this->type = 'Animateur';
	}
}
