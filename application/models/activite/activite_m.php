<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Activite_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
		parent::__construct($id);	
		
		//Table
		$this->table('actiActivite');
		
		//Declaration des champs
		$this->field('nom')->required()->unique();
		$this->field('exExercice')->related()->required();
		$this->field('actiSecteur')->related()->required();
		$this->field('actiTypeacti')->related()->required();
		$this->field('analytique');
		$this->field('maj_ext')->type('bool');
		$this->field('red_multi')->type('bool');
		$this->field('certificat')->type('bool');
		
		// Errors
		$this->error['notfound'] = 'Activite introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
