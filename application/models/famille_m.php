<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Famille_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        parent::__construct($id);	
        
        //Table
        $this->table('user_famille');
		
		//Declaration des champs
		$this->field('adresse1')->chk('notempty')->def('eheh');
		$this->field('adresse2');
		$this->field('ville')->related()->def(1)->chk('notempty');
		$this->field('ext')->type('bool');
		$this->field('qf')->type('int');
		
		// Errors
		$this->error['notfound'] = 'Famille introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
