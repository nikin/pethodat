<?php
	$DB_HOST = "localhost";
    $DB_USER = "m0000007_guest";
    $DB_PASSWORD = "PETHODATGUEST";
    $DB_DATABASE = "m0000007_pethodat";
	
//Connect to mysql server
	$link = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
//Select database
	$db = mysql_select_db($DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	
	mysql_query("set names utf8");  
?>
