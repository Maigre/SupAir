<?php
function toCamelcase($lower_case_and_underscored_word) {
	$replace = str_replace(" ", "", ucwords(str_replace("_", " ", $lower_case_and_underscored_word)));
	return $replace;
}
function toUnderscore($camel_cased_word = null) {
	$tmp = _replace($camel_cased_word, array (
		'/([A-Z]+)([A-Z][a-z])/' => '\\1_\\2',
		'/([a-z\d])([A-Z])/' => '\\1_\\2'
	));
	return $tmp;
}
function _replace($search, $replacePairs) {
	return preg_replace(array_keys($replacePairs), array_values($replacePairs), $search);
}
function pdbg($data, $color="orange", $Line=null, $File=null, $height=180, $width=800, $textcolor="#000000") {
	$dbg = debug_backtrace();
	print "<div style=\"width:".$width."px;float:left;margin:5px\">";
	print "<div style=\"border:1px solid #999;font-size:11px;\">";
	print "<div style=\"font-family:arial,helvetica;background-color:".$color.";color:".$textcolor.";padding:2px 5px;font-weight:bold;border-bottom:1px solid #999;\">";
	if(empty($line))
	    print $File;
	else
	    print $File.', LINE: '.$Line.' ';
	$offset = (isset($dbg[1])) ? 1:0;
	if($offset>0)
		print $dbg[$offset]["class"].$dbg[$offset]["type"].$dbg[$offset]["function"]."(".count( $dbg[$offset]["args"]).")";
	print "</div>";
	print "<textarea style=\"width:100%;height:".$height."px;border:none;padding:0 0 0 5px;font-size:11px\">";
	print_r($data);
	print "</textarea></div>";
	print "</div>";	
}
/**
 * __autoload
 * @desc loads framework classes
 */
function __autoload($className){

	$filename = $className.".class.php";
	
	$nodes = array();
	
	// system class first
	$absolutePathToClassFile = SYSTEMDIR . DS . $filename;
	if(is_file($absolutePathToClassFile)) {
		include_once($absolutePathToClassFile);
		return false;
	}
	
	// package domain
	$domains = explode("_",$className);
	
	$path = $domains[0];
	$absolutePathToClassFile = CLASSDIR . DS . $path . DS . $filename;
	if(is_file($absolutePathToClassFile)) {
		include_once($absolutePathToClassFile);
		return false;
	}
	// subpackage domain
	$subdomains = explode("_", toUnderscore($domains[1]));

	if(is_array($subdomains)) {
		$prevNode = "";
		$nodes[] = $domains[0];
		foreach($subdomains as $node){
			$nodes[] = $domains[0] . "_" . $prevNode . $node;
			$prevNode .= $node;
		}
	}
	// descendant package domains
	$path = implode(DS, $nodes);
	$absolutePathToClassFile = CLASSDIR . DS . $path . DS . $filename;
	if(is_file($absolutePathToClassFile)) {
		include_once($absolutePathToClassFile);
		return false;
	}
	
	// if is in parent path
	unset($nodes[count($nodes)-1]);
	$path = implode(DS, $nodes);
	$absolutePathToClassFile = CLASSDIR . DS . $path . DS . $filename;

	if(is_file($absolutePathToClassFile)) {
		include_once($absolutePathToClassFile);
		return false;
	}

	// if is in parent path
	array_shift($nodes);
	$path = implode(DS, $nodes);
	$absolutePathToClassFile = CLASSDIR . DS . $path . DS . $filename;
	if(is_file($absolutePathToClassFile)) {
		include_once($absolutePathToClassFile);
		return false;
	}
	
	// if is in parent path
	unset($nodes[count($nodes)-1]);
	$path = implode(DS, $nodes);
	$absolutePathToClassFile = CLASSDIR . DS . $path . DS . $filename;

	if(is_file($absolutePathToClassFile)) {
		include_once($absolutePathToClassFile);
		return false;
	}
	
}

