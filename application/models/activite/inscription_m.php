<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Inscription_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
		parent::__construct($id);	
		
		//Table
		$this->table('actiInscription');
		
		//Declaration des champs
		$this->field('userAdherent')->related()->required();
		$this->field('actiSession')->related()->required();
		
		$this->field('nbre_seances')->required()->type('int');		
				
		$this->field('tarif')->required()->type('float');
		//Réduc?
		$this->field('total_facture')->type('float');
		
		// Errors
		$this->error['notfound'] = 'Inscription introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
