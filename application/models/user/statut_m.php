<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Statut_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        parent::__construct($id);	
        
        //Table
        $this->table('userStatut');
		
		//Declaration des champs
		$this->field('nom')->required();
		$this->field('responsable')->type('bool');
		
		// Errors
		$this->error['notfound'] = 'Statut introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
