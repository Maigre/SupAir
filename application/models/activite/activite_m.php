<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Adherent_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
		parent::__construct($id);	
		
		//Table
		$this->table('activiteActivite');
		
		//Declaration des champs
		$this->field('nom')->required()->unique();
		$this->field('exExercice')->related()->required();
		$this->field('activiteSecteur')->related()->required();
		$this->field('activiteType')->related()->required();
		$this->field('analytique');
		$this->field('maj_ext')->type('bool');
		$this->field('red_multi')->type('bool');
		$this->field('cert_med')->type('bool');
		
		// Errors
		$this->error['notfound'] = 'Activite introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
