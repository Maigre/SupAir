<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Famille extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'user';
		$this->type = 'famille';
	}
}
