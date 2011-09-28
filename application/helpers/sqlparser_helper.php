<?php

include_once("SQLparsecompile/config.inc.php");

function histo_parse($sql)
{
	$sqlObject = new Sql_Parser($sql);
	return  $sqlObject->parse();
}

function histo_unparse($parsedSQL)
{
	$sqlObject2 = new Sql_Compiler();
	return $sqlObject2->compile($parsedSQL);
}

function histo_changeID(&$parse,$insert_table,$old_id,$new_id)
{
	$insert_table = str_replace("`","",$insert_table);
	
	if (($parse['Command'] == "insert") and ($parse['TableNames'][0] != $insert_table))
	{
		//$field_search = '`'.substr($insert_table,0,-1).'_id`';  //Datamapper style
		$field_search = '`id'.$insert_table.'`';					 //Gwikid style
		
		foreach($parse['ColumnNames'] as $id => $name)
				if (($name == $field_search) && ($parse['Values'][0][$id]['Value'] == $old_id)) $parse['Values'][0][$id]['Value'] = $new_id;
	}
	
	
	if (($parse['Command'] == "update") or ($parse['type'] == "delete"))
	{
		//if ($parse['TableNames'][0] != $insert_table) $field_search = '`'.substr($insert_table,0,-1).'_id`';	//Datamapper style
		//else $field_search = '`id`';																			//Datamapper style
		$field_search = '`id'.$insert_table.'`';																	//Gwikid style
		
		//SEARCH IN SETS
		if ($parse['Command'] == "update")					
			foreach($parse['ColumnNames'] as $id => $name)
				if (($name == $field_search) && ($parse['Values'][$id]['Value'] == $old_id)) $parse['Values'][$id]['Value'] = $new_id;
			
		//SEARCH IN WHERE'S
		if (is_array($parse['Where'])) iterativeDigger($parse['Where'],0,$field_search,$old_id,$new_id);
	}
}

//ITERATIVE SEARCH IN WHERE'S
function iterativeDigger(&$entry,$depth,$field_search,$old_id,$new_id)
{
	$max_depth = 10;

	if (isset($entry['Left']['Value']))
	{	
		if (($entry['Left']['Value'] == $field_search) && ($entry['Right']['Value'] == $old_id)) 
																					$entry['Right']['Value'] = $new_id;
	}
	else if ($depth < $max_depth)
	{
		if (isset($entry['Left']['Left'])) iterativeDigger($entry['Left'],($depth+1),$field_search,$old_id,$new_id);
		if (isset($entry['Right']['Left'])) iterativeDigger($entry['Right'],($depth+1),$field_search,$old_id,$new_id);
	}
}

/*
$sql = "INSERT INTO `Batiment` (`idBatiment`, `idSite`, `Nom`, `Annee`, `NiveauNbr`, `SurfaceSol`, `SurfaceSolReel`, `SurfaceTotal`, `SurfaceTotalReel`, `DateSaisie`, `Commentaire`, `DateCreation`, `DateFin`) VALUES (NULL, '207', 'AAb', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '2011-08-17', NULL)";
$sqli = $sql;

$pars = histo_parse($sql);
//pdbg($pars, "orange", __LINE__,__FILE__,100); 

histo_changeID($pars,'Site',207,210);

echo $sqli.'<br /><br />';
echo histo_unparse($pars);
*/













