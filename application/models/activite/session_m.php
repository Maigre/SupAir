<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Session_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
		parent::__construct($id);	
		
		//Table
		$this->table('activiteSession');
		
		//Declaration des champs
		$this->field('nom')->required()->unique();
		$this->field('activiteActivite')->related()->required();
		$this->field('dates')->required();
		
		// Errors
		$this->error['notfound'] = 'Activite introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
