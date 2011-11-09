<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Situationfam_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        parent::__construct($id);	
        
        //Table
        $this->table('userSituationfam');
		
		//Declaration des champs
		$this->field('nom')->required();
		
		// Errors
		$this->error['notfound'] = 'Situation familiale introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
