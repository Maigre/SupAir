<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Reduction_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        	parent::__construct($id);	
        
        	//Table
        	$this->table('actiReduction');
		
		//Declaration des champs
		$this->field('nom')->required()->unique();
		$this->field('valeur')->required()->unique()->type('float');	
		
		// Errors
		$this->error['notfound'] = 'Reduction introuvable';
		
		//load bean
		$this->load($id);
	}
	
	
}
