<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Calendrier_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        	parent::__construct($id);	
        
        	//Table
        	$this->table('exCalendrier');
		
		//Declaration des champs
		$this->field('exExercice')->required();
		$this->field('exPeriode')->required();
		$this->field('debut')->required()->type('date');
		$this->field('fin')->required()->type('date')->later('debut');
		
		// Errors
		$this->error['notfound'] = 'Calendrier introuvable';
		
		//load bean
		$this->load($id);
	}
	
	//overload custom validation function
	function custom_valid(&$error)
	{
		if (!$error)
		{
			$this->load->model('exercice/exercice_m');
			$exercice = new exercice_m($this->bean->exExercice->id);
		
			$ex_start = strtotime($exercice->get('debut'));
			$ex_stop = strtotime($exercice->get('fin'));
		
			if (!$exercice->test_date($this->bean->debut)) $error['debut'][] = 'outofex';
			if (!$exercice->test_date($this->bean->fin)) $error['debut'][] = 'outofex';
		}
	}
}
