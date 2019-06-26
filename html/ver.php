<?php
//Database
	require_once('config.php');
	
	echo 'Current PHP version: ' . phpversion().'<br>';
	echo 'Current MYSQL version: ';
	$t=mysql_query("select version() as ve");
	echo mysql_error();
	$r=mysql_fetch_object($t);
	echo $r->ve;
	echo '<br>';
	
	echo 'Current "PetHoDat" version: v1.0.0<br>';
	echo 'Current "PetHoDat Viewer" version: v1.0.0';
?>