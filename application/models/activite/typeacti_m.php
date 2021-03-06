<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Typeacti_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
		parent::__construct($id);	
		
		//Table
		$this->table('actiTypeacti');
		
		//Declaration des champs
		$this->field('nom')->required();
		
		// Errors
		$this->error['notfound'] = 'Type introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
