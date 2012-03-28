<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Session_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
		parent::__construct($id);	
		
		//Table
		$this->table('actiSession');
		
		//Declaration des champs
		$this->field('nom')->required()->unique();
		$this->field('actiActivite')->related()->required();
		$this->field('dates')->required();
		$this->field('periode');
		$this->field('agemin');
		$this->field('agemax');
		$this->field('capacitemin');
		$this->field('capacitemax');
		$this->field('persAnimateur')->related()->required();
		$this->field('actiNiveau')->related()->required();
		$this->field('in');
		$this->field('out');
		
		
		// Errors
		$this->error['notfound'] = 'Session introuvable';
		
		//load bean
		$this->load($id);
	} 
	
	
}
