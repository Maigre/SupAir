<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function flatten_array($Array,$Separator="_",$FlattenedKey='') 
{
	$FlattenedArray=Array();
	foreach($Array as $Key => $Value) {
		
		if (is_string($Key)) {
			if (strlen($FlattenedKey) > 0) $next_key = $FlattenedKey.$Separator.$Key;
			else $next_key = $Key;
		}
		else $next_key = $FlattenedKey; 

		
		if(is_Array($Value)) $FlattenedArray=Array_merge($FlattenedArray,flatten_array($Value,$Separator,$next_key));
		else $FlattenedArray[$next_key]=$Value;
	}
	return $FlattenedArray;
}
