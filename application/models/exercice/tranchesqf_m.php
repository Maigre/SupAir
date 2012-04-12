<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Tranchesqf_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        	parent::__construct($id);	
        
        	//Table
        	$this->table('exTranchesQF');
		
		//Declaration des champs
		$this->field('QF')->required()->type('int');
		$this->field('exExercice')->required()->related();
		//$this->field('actiActivite')->related()->required();
		
		// Errors
		$this->error['notfound'] = 'Tranche QF introuvable';
		
		//load bean
		$this->load($id);
	}
	
	
}
