<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class RedBean {

    public function __construct()
    {
    	$this->ci =& get_instance();

		// Include database configuration
		require(APPPATH.'config/database.php');

		// Include required files
		require(APPPATH.'third_party/RedBean/redbean.inc.php');

		// Database data
		$hostname     = $db[$active_group]['hostname'];
		$username     = $db[$active_group]['username'];
		$password     = $db[$active_group]['password'];
		$database     = $db[$active_group]['database'];

		// Create RedBean instance
		R::setup('mysql:host='.$hostname.';dbname='.$database, $username, $password);	
    }        
}

