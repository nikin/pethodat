<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
//GET data
	$dogID = $_GET['dogID'];
	$mit = $_GET['mit'];
	$mire = $_GET['mire'];
	
// Adatbázis elérése
	$qry="UPDATE dogs SET
			" . $mit . " = '" .  $mire . "'
			WHERE DOG_ID = '".$dogID."'";
	$result=mysql_query($qry);
?>