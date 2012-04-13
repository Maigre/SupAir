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

	//load current exercice	
	function currentExercice()
	{
		$now = date('Y-m-d');
		$this->db->select('id');
		$this->db->where('debut <=', $now);
		$this->db->where('fin >=', $now);
		$ex = $this->db->get('exExercice');
		
		$this->load($ex['id']);
		
		return $this;
	}
	
	//load last exercice	
	function lastExercice()
	{
		$this->db->select('id');
		$this->db->limit(1);
		$this->db->order_by('fin','desc');
		$ex = $this->db->get('exExercice');
		
		$this->load($ex['id']);
		
		return $this;
	}
	
	//load default new exercice based on last one	
	function newExercice()
	{
		$last_fin = strtotime($this->lastExercice()->get('fin'));
		
		$this->load();
		
		//get the last exercice and continue
		if ($last_fin > 0) {	
			$debut = strtotime("+1 day",$last_fin);
			$fin = strtotime("+1 year",$last_fin);
		}
		//if no exercice are existing
		else {
			if (date('m') > 8) {
				$debut = strtotime(date("Y").'-09-01');
				$fin = strtotime((date("Y")+1).'-08-31');
			}
			else {
				$debut = strtotime((date("Y")-1).'-09-01');
				$fin = strtotime(date("Y").'-08-31');
			}
		}
		
		$array['nom'] = date('Y',$debut).' - '.date('Y',$fin);
		$array['debut'] = date('d/m/Y',$debut);
		$array['fin'] = date('d/m/Y',$fin);
		
		$this->set($array);
		
		return $this;
	}
}
