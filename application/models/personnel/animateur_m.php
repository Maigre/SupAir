<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Animateur_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
		parent::__construct($id);	
		
		//Table
		$this->table('persAnimateur');
		
		//Declaration des champs
		$this->field('nom')->required();
		$this->field('prenom')->required();
		
		// Errors
		$this->error['notfound'] = 'Animateur introuvable';
		
		//load bean
		$this->load($id);
	}
		
}
