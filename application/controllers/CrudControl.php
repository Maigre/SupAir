<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CrudControl extends CI_Controller {

	protected $folder = 'entity';
	protected $type = 'Entity';

	function __construct()
	{
		parent::__construct();
	}
	
	private function load_model($id=false)
	{
		$class_model = $this->type.'_m';
		$this->load->model($this->folder.'/'.$class_model);
		
		return new $class_model($id);
	}
		
	function show($id=false)
	{	
		echo json_encode($this->load_model($id)->show());
	}
	
	function edit($id=false)
	{
		echo json_encode($this->load_model($id)->edit());
	}
	
	function save()
	{
		$results = $this->input->post(); 		
		echo json_encode($this->load_model()->set($results)->save());
	}
	
	function listAll()
	{
		echo json_encode(R::find($this->load_model()->table));
	}
}
