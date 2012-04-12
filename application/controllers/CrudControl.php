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
		//posted result array
		$results = $this->input->post();
		
		//Cas où le post est encodé en json et nécessite une root (='data')
		if(isset($results['data']))
		{
			$answer_type = 'rooted';
			$results = $results['data'];
			$results = json_decode( $results );
			$results = get_object_vars ( $results ); //transforme l'objet en tableau
		}
		 
		//if id posted or passed to the controller, use it (switch to edit mode)
		if ((!$id) && (isset($results['id']))) $id = $results['id'];
		
		//set and save results
		$save = $this->Entity($id)->set($results)->save();
		
		//set up answer
		$save_res = null;
		if ($answer_type == 'rooted') $save_res['data'] = $save;
		else $save_res = $save;
		 		
		jse($save);
	}
	
	function delete($id=false)
	{
		//posted result array
		$results = $this->input->post(); 
		
		//Cas où le post est encodé en json et nécessite une root (='data')
		if(isset($results['data']))
		{
			$answer_type = 'rooted';
			$results = $results['data'];
			$results = json_decode( $results );
			$results = get_object_vars ( $results ); //transforme l'objet en tableau
		}
		
		//if id posted or passed to the controller, use it (switch to edit mode)
		if ((!$id) && ($results['id'] > 0)) $id = $results['id'];
		
		//delete!	
		$del = $this->Entity($id)->delete();
		
		//set up answer
		$del_res = null;
		if ($answer_type == 'rooted') $del_res['data'] = $del;
		else $del_res = $del;
		
		jse($del_res);
	}
	
	function listAll($order=false,$depth=1)
	{		
		//TODO refactory with RedBean
		
		if($order == 'false') $order = false;
		if($order) $this->db->order_by($order);
		
		$post = array();
		
		//extract where conditions
		if ($posted = $this->input->post())
		foreach ($posted as $id=>$val)
		{
			if (($id == 'where') and (is_array($val))) foreach ($val as $w=>$v) $post['where'][$w] = $v;
			else
			{
				//old method to specify WHERE
				$where_id = explode('__',$id);
				if (isset($where_id[1]) and ($where_id[1])) $post['where'][$where_id[1]] = $val;
			}
		}
		
		//build where query		
		if (isset($post['where']) and (is_array($post['where'])))
			foreach($post['where'] as $name=>$value) $this->db->where($name,$value);
	
		//db query		
		$this->db->select('id');
		$all = $this->db->get($this->Entity()->table)->result_array();
		
		//export beans		
		$beans = array();
		foreach ($all as $a) $beans[] = $this->Entity($a['id'])->getBean();
		$e = new RedBean_Plugin_BeanExport(R::$toolbox);
    		$e->loadSchema();
    		$out = $e->exportLimited($beans,false,$depth,false,false);
		
		jse($out);
	}
}
