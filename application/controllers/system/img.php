<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Img extends CI_Controller {

	public function index()
	{

	}
	
	//list all img in a given directory
	public function listAll($dir=null)
	{
		if (!$dir) $dir = '';
		else $dir .= '/';
		
		$out = array();
		
		$img_list = get_dir_file_info('style/'.$dir,false);
		
		if ($img_list)
		foreach ($img_list as $img)
		{
			$ext = strtolower(substr($img['name'],-3,3));
			if (($ext == 'png') or ($ext == 'gif') or ($ext == 'jpg') or ($ext == 'jpeg'))
			{
				list(,$path) = explode(APP.'/style/',$img['server_path']);
				$class = str_replace('/','_',substr($path,0,-4));
		
				$out[] = array('nom' => $class);
			}
		}
		
		jse($out);
	}
}
