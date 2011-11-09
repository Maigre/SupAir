<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Famille_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        parent::__construct($id);	
        
        //Table
        $this->table('userFamille');
		
		//Declaration des champs
		$this->field('adresse1')->required();
		$this->field('adresse2');
		$this->field('userVille')->related()->def(1)->required();
		$this->field('ext')->type('bool');
		$this->field('qf')->type('int');
		$this->field('ccas')->type('bool');
		$this->field('bonv')->type('bool');
		
		// Errors
		$this->error['notfound'] = 'Famille introuvable';
		
		//load bean
		$this->load($id);
	}
	
	
}
