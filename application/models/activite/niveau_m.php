<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Niveau_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        	parent::__construct($id);	
        
        	//Table
        	$this->table('actiNiveau');
		
		//Declaration des champs
		$this->field('nom')->required()->unique();
		
		// Errors
		$this->error['notfound'] = 'Niveau introuvable';
		
		//load bean
		$this->load($id);
	}
	
	
}
