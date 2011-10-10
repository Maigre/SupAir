<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'controllers/CrudControl.php');

class Adherent extends CrudControl {

	function __construct()
	{
		parent::__construct();
		$this->folder = 'user';
		$this->type = 'adherent';
	}
	
	function search($txt)
	{
		$this->db->select('id','nom','prenom');
		$this->db->like('nom',$txt,'after');
		$this->db->get('userAdherent');
		
		return json_encode($this->db->result_array());
	}
}
