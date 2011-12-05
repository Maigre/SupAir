<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Exercice_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        	parent::__construct($id);	
        
        	//Table
        	$this->table('exExercice');
		
		//Declaration des champs
		$this->field('nom')->required();
		$this->field('debut')->required()->type('date');
		$this->field('fin')->required()->type('date');
		
		// Errors
		$this->error['notfound'] = 'Exercice introuvable';
		
		//load bean
		$this->load($id);
	}
	
	
}
