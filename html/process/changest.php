<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
//GET data
	$dogID = $_GET['dogID'];
	$stID = $_GET['stID'];

	$Time = Date("Y-m-d m:i:s");
	$Date = date('Y-m-d');
		
// Adatbázis elérése
	$qry="UPDATE dogs SET
			STATUS = '" .  $stID . "'
			WHERE DOG_ID = '".$dogID."'";
	$result=mysql_query($qry);
	
	if ($stID == 'ST5') {
		$Dqry="UPDATE dogs SET
			D_DATE = '" .  $Date . "'
			WHERE DOG_ID = '".$dogID."'";
		$Dresult=mysql_query($Dqry);
	}
	
	$LOGqry = "INSERT INTO log SET
				USER_ID = '" . $_SESSION['SESS_MEMBER_ID'] . "',
				DOG_ID = '" . $dogID . "',
				ACTION = 'A1',
				COMMENT = 'Új Státusz: ".DataName($stID)."'";
	$LOGresult=mysql_query($LOGqry);
	
//------ ARCIVÁLÁS --------
	if ($stID == 'ST5') {
		$ArDqry="INSERT INTO archive_dogs SELECT * FROM dogs WHERE DOG_ID = '".$dogID."'";
		$ArDresult=mysql_query($ArDqry);
		$ArDelqry="DELETE FROM dogs WHERE DOG_ID = '".$dogID."'";
		$ArDelresult=mysql_query($ArDelqry);
		
		$ArLogqry="INSERT INTO archive_log SELECT * FROM log WHERE DOG_ID = '".$dogID."'";
		$ArLogresult=mysql_query($ArLogqry);
		$ArLogDelqry="DELETE FROM log WHERE DOG_ID = '".$dogID."'";
		$ArLogDelresult=mysql_query($ArLogDelqry);		
	}
?>