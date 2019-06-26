<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
//GET data
	$Table =  $_GET['Table'];
	$ID = $_GET['ID'];
	$Comment = $_GET['COMMENT'];
	
// Adatbázis elérése
	switch ($Table) {
		case dogs:
			$ArchQRY="SELECT * FROM dogs WHERE DOG_ID='".$ID."'";
			$ArchResult=mysql_query($ArchQRY);
			if (mysql_num_rows($ArchResult) == 0 ){
				$dogT="archive_dogs";
			}
			else{
				$dogT="dogs";
			}
			$qry="UPDATE ".$dogT." SET
					COMMENT = '" .  $Comment . "'
					WHERE DOG_ID = '".$ID."'";
			$result=mysql_query($qry);
			break;
		case owner:
			$qry="UPDATE owner SET
					COMMENT = '" .  $Comment . "'
					WHERE OWNER_ID = '".$ID."'";
			$result=mysql_query($qry);
			break;

	}
?>