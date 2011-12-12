<style>
<?php

if ($img_list)
foreach ($img_list as $img)
{
	//print_r($img);
	$ext = strtolower(substr($img['name'],-3,3));
	
	if (($ext == 'png') or ($ext == 'gif') or ($ext == 'jpg') or ($ext == 'jpeg'))
	{
		list(,$path) = explode(APP.'/style/',$img['server_path']);
		$class = str_replace('/','_',substr($path,0,-4));
		
		echo ".".$class." { background:url('style/".$path."') no-repeat; }\n";
	}
}

?>
</style>
