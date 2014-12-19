<?php 
		
	include "lib/json.php";

 	$jsonAntigo = $json;
 	$json = new Json;

	$json->sugestoes = array();
	$json->sugestoes[] = $jsonAntigo->name . " 1";
	$json->sugestoes[] = $jsonAntigo->name . " 2";
	$json->sugestoes[] = $jsonAntigo->name . " 3";
	$json->sugestoes[] = $jsonAntigo->name . " 4";
	$json->sugestoes[] = $jsonAntigo->name . " 5";
 
	$json->send();


?>