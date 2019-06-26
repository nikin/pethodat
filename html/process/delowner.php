<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
	$dogID = $_GET['dogID'];
	
	$SaveQRY="UPDATE archive_dogs SET OWNER_ID = '0', STATUS = 'ST6', ADOPT_DATE = '0' WHERE DOG_ID = '".$dogID."'";
	$SaveResult=mysql_query($SaveQRY);
	
	//------ ARCIVÁLÁS --------
	$ArDqry="INSERT INTO dogs SELECT * FROM archive_dogs WHERE DOG_ID = '".$dogID."'";
	$ArDresult=mysql_query($ArDqry);
	$ArLogqry="INSERT INTO log SELECT * FROM archive_log WHERE DOG_ID = '".$dogID."'";
	$ArLogresult=mysql_query($ArLogqry);
	$ArMedqry="INSERT INTO medical SELECT * FROM archive_medical WHERE DOG_ID = '".$dogID."'";
	$ArMedresult=mysql_query($ArMedqry);
	
	if ($ArDresult) {
		$ArDelqry="DELETE FROM archive_dogs WHERE DOG_ID = '".$dogID."'";
		$ArDelresult=mysql_query($ArDelqry);
	}
	if ($ArLogresult){
		$ArLogDelqry="DELETE FROM archive_log WHERE DOG_ID = '".$dogID."'";
		$ArLogDelresult=mysql_query($ArLogDelqry);
	}
	if ($ArMedresult){
		$ArMedDelqry="DELETE FROM archive_medical WHERE DOG_ID = '".$dogID."'";
		$ArMedDelresult=mysql_query($ArMedDelqry);
	}
	$LOGqry = "INSERT INTO log SET
				USER_ID = '" . $_SESSION['SESS_MEMBER_ID'] . "',
				DOG_ID = '" . $dogID . "',
				ACTION = 'A4',
				OWNER_ID = '',
				COMMENT = 'Új Státusz: ".DataName('ST6')."'";
	$LOGresult=mysql_query($LOGqry);
?>