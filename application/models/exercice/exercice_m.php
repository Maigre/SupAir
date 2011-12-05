<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'models/entity.php');

class Exercice_m extends Entity_m {
	
	function __construct($id=false)
	{
		// Call the Entity constructor
        	parent::__construct($id);	
        
        	//Table
        	$this->table('exExercice');
		
		//Declaration des champs
		$this->field('nom')->required()->unique();
		$this->field('debut')->required()->type('date');
		$this->field('fin')->required()->type('date')->later('debut');
		
		// Errors
		$this->error['notfound'] = 'Exercice introuvable';
		
		//load bean
		$this->load($id);
	}
	
	//test if a date is in the loaded exercice
	function test_date($date)
	{
		$debut = strtotime($this->get('debut'));
		$fin = strtotime($this->get('fin'));
		$date = strtotime($date);
		
		if (($debut) and ($fin) and ($date) and ($date >= $debut) and ($date <= $fin)) return true;
		else return false;
	}
}
