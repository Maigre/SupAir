<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Ville extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'user';
		$this->type = 'ville';
	}
}
