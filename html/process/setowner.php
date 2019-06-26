<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');

	$ownerID = $_POST['Owners'];
	$dogID = $_POST['dogID'];
	$Date = Date("Y-m-d");
	
	$SaveQRY="UPDATE dogs SET OWNER_ID = '".$ownerID."', STATUS = 'ST4', ADOPT_DATE = '".$Date."' WHERE DOG_ID = '".$dogID."'";
	$SaveResult=mysql_query($SaveQRY);
	
	$LOGqry = "INSERT INTO log SET
				USER_ID = '" . $_SESSION['SESS_MEMBER_ID'] . "',
				DOG_ID = '" . $dogID . "',
				ACTION = 'A3',
				OWNER_ID = '" . $ownerID . "',
				COMMENT = ''";
	$LOGresult=mysql_query($LOGqry);
	
	
	//------ ARCIVÁLÁS --------
	$ArDqry="INSERT INTO archive_dogs SELECT * FROM dogs WHERE DOG_ID = '".$dogID."'";
	$ArDresult=mysql_query($ArDqry);
	$ArLogqry="INSERT INTO archive_log SELECT * FROM log WHERE DOG_ID = '".$dogID."'";
	$ArLogresult=mysql_query($ArLogqry);
	$ArMedqry="INSERT INTO archive_medical SELECT * FROM medical WHERE DOG_ID = '".$dogID."'";
	$ArMedresult=mysql_query($ArMedqry);
	
	if($ArDresult){
		$ArDelqry="DELETE FROM dogs WHERE DOG_ID = '".$dogID."'";
		$ArDelresult=mysql_query($ArDelqry);
	}
	if($ArLogresult){
		$ArLogDelqry="DELETE FROM log WHERE DOG_ID = '".$dogID."'";
		$ArLogDelresult=mysql_query($ArLogDelqry);
	}
	if($ArMedresult){
		$ArMedDelqry="DELETE FROM medical WHERE DOG_ID = '".$dogID."'";
		$ArMedDelresult=mysql_query($ArMedDelqry);
	}
	
	print "<script language=\"javascript\" type=\"text/javascript\">
				location.href='../member-index.php?oldal=adatlap&ID=".$dogID."'
			</script>";
?>