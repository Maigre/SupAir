<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Codesociopro_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        parent::__construct($id);	
        
        //Table
        $this->table('userCodesociopro');
		
		//Declaration des champs
		$this->field('nom')->required();
		
		// Errors
		$this->error['notfound'] = 'CSP introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
