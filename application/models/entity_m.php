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

	//load bean from id
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
	
	//get array of bean values for display (recursive)
	function show()
	{
		if ($this->bean->id)
		{

			$beans[] = $this->bean;
						
			//new export allow
			$e = new RedBean_Plugin_BeanExport(R::$toolbox);
    			$e->loadSchema();
    			$array = $e->exportLimited($beans,false,2,false,false);
									
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
	
	//get array of bean values for edit (not recursive)
	function edit()
	{	
		if (!is_object($this->bean)) $this->load();
		$out['data'] = $this->bean->export();
		return $out;
	}
	
	//get value from bean
	function get($field_name)
	{
		$fields = explode('_',$field_name);
		
		$bean = $this->bean;		
		foreach($fields as $n) 
			if (isset($bean->{$n})) $bean = $bean->{$n}; 
			else return null;
		
		return $bean;
	}	
	
	//build bean from posted data
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
	
	//formatage des champs
	function format()
	{
		foreach($this->fields as $n=>$fi) 
		{
			if (!$fi->relatedTo)
			{
				$this->bean->{$n} = trim($this->bean->{$n});
				
				if ($fi->type == 'bool') $this->bean->{$n} = (bool) $this->bean->{$n};
				if ($fi->type == 'float') $this->bean->{$n} = str_replace(',','.',$this->bean->{$n});
				if ($fi->type == 'upper') $this->bean->{$n} = strtoupper($this->bean->{$n});
				if ($fi->type == 'upword') $this->bean->{$n} = ucwords($this->bean->{$n});
				if ($fi->type == 'date') 
				{
					$this->bean->{$n} = substr($this->bean->{$n},0,10);
					$xpld = explode('-',$this->bean->{$n});
					if (count($xpld != 3))
					{ 
						$xpld = explode('/',$this->bean->{$n}); 
						if (count($xpld) == 3) $this->bean->{$n} = $xpld[2].'-'.$xpld[1].'-'.$xpld[0];
					}
				}
			}
		}
		
		return $this;
	}
	
	//validation des champs
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
						if(!isset($this->bean->{$n}->id) or (!($this->bean->{$n}->id>0))) $error[$n][] = 'empty'; 
					}
					elseif (!$this->bean->{$n}) $error[$n][] = 'empty';
					
				}
				//
				
				//unique
				if ($fi->unique) 
				{
					$r_u = array();
					
					if($fi->relatedTo) $r_u = $this->db->where($n.'_id',$this->bean->{$n}->id)->get($this->table)->result_array();
					else $r_u = $this->db->where($n,$this->bean->{$n})->get($this->table)->result_array();

					if (count($r_u) > 0)
							foreach($r_u as $rr_u) 
								if ($rr_u['id'] != $this->bean->id) {$error[$n][] = 'alreadyexist'; break;}
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
					$xpld = explode('-',$this->bean->{$n}); 		
					if (!checkdate($xpld[1],$xpld[2],$xpld[0])) $error[$n][] = 'invaliddate';
				}
				//
				
				//minimum relative to another field (must be tested before min/max/equal !)
				//usefull fo date upside down test
				if (($fi->later) and isset($this->bean->{$fi->later}))
				{
					$fi->min($this->bean->{$fi->later});
				}
				//
				
				//min/max/equal
					//prepare value
					$value = null;
					if ($fi->relatedTo) 
					{ 
						if(isset($this->bean->{$n}->id))
							$value = $this->bean->{$n}->id;
					}
					elseif ($fi->type == 'date') $value = strtotime($this->bean->{$n});
					else $value = $this->bean->{$n};
				
				//equal
				if ((isset($fi->equal)) and ($value !== $fi->equal))
				{	
					if ($fi->type == 'date') $error[$n][] = 'not=='.date('Y-m-d',$fi->max);
					else $error[$n][] = 'not=='.$fi->equal;
				}
				//max
				if ((isset($fi->max)) and ($value > $fi->max))
				{	
					if ($fi->type == 'date') $error[$n][] = 'not<='.date('Y-m-d',$fi->max);
					else $error[$n][] = 'not<='.$fi->max;
				}
				//min
				if ((isset($fi->min)) and ($value < $fi->min)) 
				{	
					if ($fi->type == 'date') $error[$n][] = 'not>='.date('Y-m-d',$fi->min);
					else $error[$n][] = 'not>='.$fi->min;
				}
				//
			}
		}
		
		//start custom validation (overloaded in model description)
		$this->custom_valid($error);
		
		if (!$error) return true;
		else return $error;
	}
	
	//custom validation 
	//to be overloaded in model description
	function custom_valid(&$error)
	{
		//do nothing here.. overload it !
	}
	
	//sauvegarde le bean dans la base de donnée 
	//ou l'entité en flashdata pour utilisation à la prochaine requete'
	function save($flashdata_store=false)
	{
		$validation = $this->valid();
		
		if ($validation === true) 
		{
			if (!$flashdata_store) $out['id'] = R::store($this->bean);
			else $this->session->set_flashdata($flashdata_store,serialize($this->bean));
			
			$out['success'] = true;
		}
		else 
		{
			$out['error'] = $validation;
			$out['success'] = false;
		}
		
		return $out;
	}
		
	function getBean()
	{
		if (!is_object($this->bean)) $this->load();
		return $this->bean;
	}
	
	function setBean($bean)
	{
		$this->bean = $bean;
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
	
	
	
	protected function flatten_array($Array,$Separator="_",$FlattenedKey='') 
	{
		$FlattenedArray=Array();
		foreach($Array as $Key => $Value) {
			
			if (is_string($Key)) {
				if (strlen($FlattenedKey) > 0) $next_key = $FlattenedKey.$Separator.$Key;
				else $next_key = $Key;
			}
			else $next_key = $FlattenedKey; 
	
			
			if(is_Array($Value)) $FlattenedArray=Array_merge($FlattenedArray,$this->flatten_array($Value,$Separator,$next_key));
			else $FlattenedArray[$next_key]=$Value;
		}
		return $FlattenedArray;
	}

}

class Field {

	var $name = null;
	var $relatedTo = null;
	var $value = null;
	var $type = 'str';
	var $rule = null;
	var $required = false;
	var $unique = false;
	var $later = null;
	
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
	
	function unique()
	{
		$this->unique = true;
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
	
	function later($field)
	{
		$this->later = $field;
		return $this;
	}
}
