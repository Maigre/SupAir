<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Activite extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'activite';
		$this->type = 'Activite';
	}
	
	//renvoi l'id de l'activite' et celui de chaque session
	function loadActivite($id_activite=false)
	{		
		$sessions = $this->Entity($id_activite)->getBean()->ownActiSession;
		
		$out['activite'] = $id_activite;
		foreach($sessions as $sess) $out['session'][] = $sess->id;
	
		jse($out);
	}
}
