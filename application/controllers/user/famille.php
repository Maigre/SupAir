<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Famille extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'user';
		$this->type = 'famille';
	}
	
	//renvoi l'id de la famille et celui de chaque adherent
	function loadFamille($id_famille=false)
	{
		$adherents = $this->Entity($id_famille)->getBean()->ownUserAdherent;

		foreach($adherents as $adh) 
		{
			if ($adh->userStatut->id == 1) $out['referent']  = $adh['id'];
			elseif ($adh->userStatut->id == 2) $out['conjoint']  = $adh['id'];
			else $out['enfants'][] = $adh['id'];
		}
		
		jse($out);
	}
	
	
	//surcharge de la fonction save
	function save($id=false)
	{
		// lors de la creation d'une nouvelle famille, on stocke la famille
		// en tampon pour la valider et l'enregistrer lorsqu'on recevra le referent !
		// on utilise flashdata de CI : donnée stockée en session jusqu'à la prochaine requete seulement
		// pour cela il suffit de préciser le nom de la variable flash data au save de l'enitity'
		
		if (!$id) $flash = 'newFamille';
		else $flash = false;
		
		$results = $this->input->post(); 		
		jse($this->Entity($id)->set($results)->save($flash));
	}
}
