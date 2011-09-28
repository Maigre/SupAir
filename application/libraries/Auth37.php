<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auth37 {

    private $user = '';
    private $level = 0;
    private $logBit = false;
    
    public function __construct()
    {
    	$CI =& get_instance();
    	$uri = explode('/',uri_string());
    	
    	$this->recognize_user();
    	
    	//you can only access default controller or auth controller if you're not logged in)
    	if (($this->logged() == 0)&&($uri[0] != '')&&($uri[0] != 'auth'))
    							exit('Access restricted.. take a break !');    	
    }
    
    private function recognize_user()
    {
    	$CI =& get_instance();
    	$u = $CI->session->userdata('AUTH37_user');
    	$l = $CI->session->userdata('AUTH37_level');
    	$b = $CI->session->userdata('AUTH37_logbit');
    	
    	if (($u != '')&&($l > 0)&&($b == 1))
    	{
    		$this->user = $u;
    		$this->level = $l;
    		$this->logBit = true;
    	}
    	else 
    	{
    		$this->user = '';
    		$this->level = 0;
    		$this->logBit = false;
    	}
    }
    
    public function logged()
    {
    	if (($this->logBit)&&($this->user != '')&&($this->level > 0)) return $this->level;
    	else return 0;
    }
    
    public function user()
    {
    	if ($this->logged()) return $this->user;
    	else return null;
    }
    
    public function login($user,$pass)
    {
    	if (trim($user) != '')
    	{
			$CI =& get_instance();
			
			//check password from main_db 
			//and get user info & config
			$CI->db->where('user',$user);
			$res = $CI->db->get('system_users',1);
			
			if ($res->num_rows() > 0)
			{
				$result = $res->row_array();
			
				if ($CI->encrypt->sha1($pass) == $result['password'])
				{
					$this->user = $user;
					$this->level = $result['level'];
					$this->logBit = true;
			
					$CI->session->set_userdata('AUTH37_user',$this->user);
					$CI->session->set_userdata('AUTH37_level',$this->level);
					$CI->session->set_userdata('AUTH37_logbit',$this->logBit);
			
					return true;
				}
			}
		}
		return false;
    }
    
    public function logout()
    {
		$CI =& get_instance();
			
		$this->user = '';
		$this->level = 0;
		$this->logBit = false;
		
		$CI->session->set_userdata('AUTH37_user',$this->user);
		$CI->session->set_userdata('AUTH37_level',$this->level);
		$CI->session->set_userdata('AUTH37_logbit',$this->logBit);
		
		$CI->session->sess_destroy();	
		return ($this->logged() == 0);
    }
    
        
}

