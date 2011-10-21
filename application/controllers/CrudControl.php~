<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CrudControl extends CI_Controller {

	protected $folder = 'entity';
	protected $type = 'Entity';

	function __construct()
	{
		parent::__construct();
	}
	
	//permet de charger un model Entity (par defaut celui portant le meme nom que $this->type du controlleur)
	protected function Entity($id=false,$model=false,$folder=false)
	{
		//by default load the model corresponding to the controler type
		//also usable to load another model
		
		if ($model) $class_model = $model.'_m';
		else $class_model = $this->type.'_m';
		
		if ($folder) $path = $folder;
		else $path = $this->folder;
		
		if (!isset($this->$class_model)) 
			$this->load->model($this->folder.'/'.$class_model);
		
		return new $class_model($id);
	}
		
	function show($id=false)
	{	
		jse($this->Entity($id)->show());
	}
	
	function edit($id=false)
	{
		jse($this->Entity($id)->edit());
	}
	
	function save($id=false)
	{
		$results = $this->input->post(); 		
		jse($this->Entity($id)->set($results)->save());
	}
	
	function listAll()
	{
		$all = R::find($this->Entity()->table);
		foreach ($all as $a) $out[] = $a->export();
		jse($out);
	}
}
