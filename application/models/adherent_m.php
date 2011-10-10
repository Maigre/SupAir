<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Adherent_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        parent::__construct($id);	
        
        //Table
        $this->table('userAdherent');
		
		//Declaration des champs
		$this->field('user-famille')->related()->required();
		$this->field('user-statut')->related()->required();
		$this->field('nom')->required();
		$this->field('prenom')->required();
		$this->field('sexe')->type('bool');
		$this->field('naissance')->type('date');
		$this->field('sante')->type('bool');
		$this->field('svsp')->type('bool');
		$this->field('autosortie')->type('bool');
		$this->field('email');
		$this->field('portable');
		$this->field('fixe');
		$this->field('bureau');
		$this->field('user-situationfam')->related();
		$this->field('user-codesociopro')->related();
		$this->field('employeur');
		$this->field('allocataire')->type('bool');
		$this->field('noalloc')->type('int');
		$this->field('nosecu')->type('int');
		
		// Errors
		$this->error['notfound'] = 'Adhérent introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
