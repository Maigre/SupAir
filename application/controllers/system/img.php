<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Img extends CI_Controller {

	public function index()
	{

	}
	
	//list all img in a given directory
	public function listAll($dir)
	{
		if ($handle = opendir('style/'.$dir.'/')) {
		
		    /* This is the correct way to loop over the directory. */
		    while (false !== ($entry = readdir($handle))) {
			if (preg_match("/.+(jpe?g|gif|png)$/i",$entry)) $out['files'][] = $entry;
		    }

		    closedir($handle);
		    $out['success'] = true;
		}
		else 
		{
			$out['success'] = false;
			$out['error'] = 'Unknown directory';
		}
		
		jse($out);
	}
}
