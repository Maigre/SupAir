<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Calendrier extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'exercice';
		$this->type = 'calendrier';
	}
	
	//liste des dates en vrac du calendrier ($cal_type : 0-all / 1-vacances / 2-fermé) ($ex : exercice, 0 for current)
	function listDates($cal_type = 0, $ex = 0)
	{
		//set current exercice if none provided
		if (!$ex) $ex = $this->Entity(false,'exercice')->currentExercice()->get('id');
		
		$this->db->where('exExercice_id',$ex);
		if ($cal_type > 0) $this->db->where('cal_id',$cal_type);
		$dates = $this->db->get('exCalendrier')->result_array();
		
		
		$list = array();
		foreach ($dates as $cal) 
		{
			//print_r($cal);
			if ($cal['cal_id'] == 1) $index = 'vacances';
			else $index = 'ferme';
			
			for ($i = strtotime($cal['debut']); $i <= strtotime($cal['fin']); $i = strtotime("+1 day", $i)) $list[$index][] = date("d/m/y",$i); 
		}
			
		$out['data'] = $list;
		
		jse($out); 
	}
}
