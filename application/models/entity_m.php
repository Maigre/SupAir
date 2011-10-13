<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entity_m extends CI_Model {

	private $debug = true;
	
	public $table;
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
		//creer la table si inexistante
		if (($this->debug) and (!$this->db->table_exists($this->table)))
		{
			$this->dBean();
			R::store($this->bean);
			R::trash($this->bean);
		}

		//charger un bean ou le bean par defaut
		if (is_numeric($id) and ($id > 0)) $this->bean = R::load($this->table,(int) $id);
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
	
	function get($field_name)
	{
		$fields = explode('_',$field_name);
		
		$bean = $this->bean;		
		foreach($fields as $n) 
			if (isset($bean->{$n})) $bean = $bean->{$n}; 
			else return null;
		
		return $bean;
	}	
	
	function set($data)
	{
		foreach($this->fields as $n=>$fi) 
		{	
			if ($n != 'id')
			{
				if ($fi->relatedTo) {if (isset($data[$n.'_id'])) $this->bean->{$n} = R::load($fi->relatedTo,(int) $data[$n.'_id']);}
				else if (isset($data[$n])) $this->bean->{$n} = $data[$n];
			}
		}
		
		return $this;
	}
	
	function format()
	{
		foreach($this->fields as $n=>$fi) 
		{
			$this->bean->{$n} = trim($this->bean->{$n});
			
			if ($fi->type == 'bool') $this->bean->{$n} = (bool) $this->bean->{$n};
			if ($fi->type == 'float') $this->bean->{$n} = str_replace(',','.',$this->bean->{$n});
			if ($fi->type == 'upper') $this->bean->{$n} = strtoupper(',','.',$this->bean->{$n});
			if ($fi->type == 'upword') $this->bean->{$n} = ucwords($this->bean->{$n});
		}
		
		return $this;
	}
	
	function valid($exclude=null)
	{
		$this->format();
		
		if (!is_array($exclude)) $exclude = array($exclude);
		
		$error = null;
		
		foreach($this->fields as $n=>$fi) 
		{		
			if (!in_array($n,$exclude))
			{
				//notempty
				if (($fi->rule == 'notempty') or $fi->required) 
				{
					if($fi->relatedTo) 
					{
						if(!isset($this->bean->{$n}->id)) $error[$n][] = 'empty'; 
					}
					elseif (!$this->bean->{$n}) $error[$n][] = 'empty';
					
				}
				//
				
				//isnumeric
				if (($fi->type == 'int') or ($fi->type == 'float')) 
				{
					if (!is_numeric($this->bean->{$n})) $error[$n][] = 'notnumeric';
					else if ($fi->type == 'int') $this->bean->{$n} = (int) $this->bean->{$n};
					else if ($fi->type == 'float') $this->bean->{$n} = (float) $this->bean->{$n};
				}
				//
				
				//date
				if (($fi->type == 'date') and ($this->bean->{$n})) 
				{
					list($y,$m,$d) = explode('-',$this->bean->{$n}); 
					if (!checkdate($m,$d,$y)) $error[$n][] = 'notdate';
				}
				//
				
				//min/max/equal
					//prepare value
					$value = null;
					if ($fi->relatedTo) 
					{ 
						if(!isset($this->bean->{$n}->id))
							$value = $this->bean->{$n}->id;
					}
					elseif ($fi->type == 'date') $value = strtotime($this->bean->{$n});
					else $value = $this->bean->{$n};
				
				//equal
				if ((isset($fi->equal)) and ($value !== $fi->equal)) $error[$n][] = 'not=='.$fi->equal;
				//max
				if ((isset($fi->max)) and ($value > $fi->max)) $error[$n][] = 'not<='.$fi->max;
				//min
				if ((isset($fi->min)) and ($value < $fi->min)) $error[$n][] = 'not>='.$fi->min;
				//
			}
		}
		
		if (!$error) return true;
		else return $error;
	}
	
	//sauvegarde le bean dans la base de donnée 
	//ou l'entité en flashdata pour utilisation à la prochaine requete'
	function save($flashdata_store=false)
	{
		$validation = $this->valid();
		
		if ($validation === true) 
		{
			if (!$flashdata_store) $out['id'] = R::store($this->bean);
			else $this->session->set_flashdata($flashdata_store,$this);
			
			$out['success'] = true;
			return $out;
		}
		else $validation['success'] = false;
		
		return $validation;
	}
		
	function getBean($id=null)
	{
		if (!is_object($this->bean)) $this->load();
		return $this->bean;
	}
	
	//ajoute des champs et leur proprietés de formatage et validation
	function field($name)
	{
		if(!isset($this->fields[$name])) 
			$this->fields[$name] = new Field($name);
	
		return $this->fields[$name];
	}
	
	protected function error($name)
	{
		if (isset($this->error[$name])) return 'Erreur : '.$this->error[$name];
		else return 'Erreur : '.$this->table.' '.$name;
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
		return $this;
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
	
	function equal($value)
	{
		if ($this->type == 'date') $value = strtotime($value);
		$this->equal = $value;
		return $this;
	}
	
	function max($value)
	{
		if ($this->type == 'date') $value = strtotime($value);
		$this->max = $value;
		return $this;
	}
	
	function min($value)
	{
		if ($this->type == 'date') $value = strtotime($value);
		$this->min = $value;
		return $this;
	}
}
