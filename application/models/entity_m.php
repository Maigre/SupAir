<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entity_m extends CI_Model {

	protected $table;
    protected $bean = null;
    protected $fields = array();
	protected $error = array();

	function __construct()
	{
		// Call the Model constructor
        parent::__construct();		
	}

	function load($id=false)
	{
		if ($id) $this->bean = R::load($this->table,(int) $id);
		if (!isset($this->bean->id)) $this->dBean();
	}
	
	function show()
	{
		if ($this->bean->id)
		{
			$beans[] = $this->bean;
			$array = R::exportAll($beans,true);
			$out['data'] = $this->flatten_array(current($array));
			$out['succes'] = true;
		}
		else 
		{
			$out['succes'] = false;
			$out['error'] = $this->error('notfound');
		}
		
		return $out;
	}

	function edit()
	{	
		if (!is_object($this->bean)) $this->load();
		$out['data'] = $this->bean->export();
		return $out;
	}	
	
	function set($data)
	{
		foreach($this->fields as $n=>$fi) 
		{	
			if ($fi->relatedTo) {if (isset($data[$n.'_id'])) $this->bean->{$n} = R::load($fi->relatedTo,(int) $data[$n.'_id']);}
			else if (isset($data[$n])) $this->bean->{$n} = $data[$n];
		}
	}
	
	function format()
	{
		foreach($this->fields as $n=>$fi) 
		{
			$this->bean->{$n} = trim($this->bean->{$n});
			
			if ($fi->type == 'bool') $this->bean->{$n} = (bool) $this->bean->{$n};
			if ($fi->type == 'float') $this->bean->{$n} = str_replace(',','.',$this->bean->{$n});
		}
	}
	
	function valid()
	{
		$error = null;
		
		foreach($this->fields as $n=>$fi) 
		{		
			if (($fi->rule == 'notempty') or $fi->required) {if($fi->relatedTo) {if(!isset($this->bean->{$n}->id)) $error[$n][] = 'empty'; elseif (!$this->bean->{$n}) $error[$n][] = 'empty';}}
			if (($fi->type == 'int') or ($fi->type == 'float')) {if (!is_numeric($this->bean->{$n})) $error[$n][] = 'notnumeric';}
			if (($fi->type == 'date') and ($this->bean->{$n})) {list($y,$m,$d) = explode('-',$this->bean->{$n}); if (!checkdate($m,$d,$y)) $error[$n][] = 'notdate';}
		}
		
		if (!$error) return true;
		else return $error;
	}
	
	function save()
	{
		$this->format();
		$validation = $this->valid();
		
		if ($validation === true) return R::store($this->bean);
		else return $validation;
	}
		
	function getBean($id=null)
	{
		if (!is_object($this->bean)) $this->load();
		return $this->bean;
	}
	
	protected function error($name)
	{
		if (isset($this->error[$name])) return 'Erreur : '.$this->error[$name];
		else return 'Erreur : '.$this->table.' '.$name;
	}
	
	protected function field($name)
	{
		$this->fields[$name] = new Field($name);
		return $this->fields[$name];
	}
	
	protected function table($table)
	{
		$this->table = $table;
	}
	
	protected function dBean()
	{
		$this->bean = R::dispense($this->table);
		
		foreach($this->fields as $n=>$fi) 
		{
			if ($fi->relatedTo) $this->bean->{$n.'_id'} = $fi->value;
			else $this->bean->{$n} = $fi->value;
		}
	}
	
	protected function flatten_array($array, $preserve_keys = 1, &$out = array(), &$last_subarray_found="") 
	{
		    foreach($array as $key => $child)
		    {
		        if(is_array($child))
		        {
		            if($preserve_keys + is_string($key) > 1) 
		            {
		             	if($last_subarray_found) $last_subarray_found .= '_'.$key;
		             	else $last_subarray_found = $key;
		            }
		            $out = $this->flatten_array($child, $preserve_keys, $out, $last_subarray_found);
		        }
		        elseif($preserve_keys + is_string($key) > 1)
		        {
		            if ($last_subarray_found) $sfinal_key_value = $last_subarray_found . "_" . $key;
		            else  $sfinal_key_value = $key;
		            $out[$sfinal_key_value] = $child;
		        }
		        else $out[] = $child;
		    }

		    return $out;
	}

}

class Field {

	var $name = null;
	var $relatedTo = null;
	var $value = null;
	var $type = 'str';
	var $rule = null;
	var $required = false;
	
	function __construct($name)
	{
		$this->name = $name;
	}
	
	function related($table=false)
	{
		if ($table) $this->relatedTo = $table;
		elseif ($this->name) $this->relatedTo = $this->name;
		$this->type = 'related';
		return $this;
	}
	
	function required()
	{
		$this->required = true;
	}
	
	function def($value=null)
	{
		$this->value = $value;
		return $this;
	}
	
	function type($type=false)
	{
		if ($type) $this->type = $type;
		return $this;
	}
	
	function chk($rule=false)
	{
		if ($rule) $this->rule = $rule;
		return $this;
	}
}
