<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Exercice extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'exercice';
		$this->type = 'exercice';
	}
	
	function getNewExercice()
	{
		jse($this->Entity()->newExercice()->edit());		
	}
	
	function getCurrentExercice()
	{
		jse($this->Entity()->currentExercice()->show());		
	}
	
	function getLastExercice()
	{
		jse($this->Entity()->lastExercice()->show());		
	}
}
