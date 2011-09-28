<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*


zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr


*/

class Auth extends CI_Controller {

	//ASK if logged in or not, if ok send user and level
	public function index()
	{
		if ($this->auth37->logged() > 0)
		{
			echo "{success : true,user: \"".$this->auth37->user()."\",level: \"".$this->auth37->logged()."\"}";
		}
		else
		{
			echo "{success : false}";
		}
	}
	
	//try to login
	public function login()
	{
		$log = $this->auth37->login($this->input->post('login'),$this->input->post('password'));
		
		if ($log) echo "{success : true, user : \"".$this->auth37->user()."\"}";
		else echo "{success : false, msg : \"Zut, impossible de vous identifier. Réessayez ! (attention au majuscules)\"}";
	}
	
	//logout
	public function logout()
	{
		$log = $this->auth37->logout();
		
		if ($log) echo "{success : true}";
		else echo "{success : false, msg : \"Zut, impossible de vous déconnecter... Redémarrez votre navigateur internet !\"}";
	}
}
