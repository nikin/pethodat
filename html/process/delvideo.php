<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
	$ID = $_GET['ID'];
		
	$Yqry = "DELETE FROM video WHERE ID = ".$ID;
	$Yresult=mysql_query($Yqry);

	$Time = date("Y-m-d m:i:s");
	$LOGqry = "INSERT INTO log SET
				USER_ID = '" . $_SESSION['SESS_MEMBER_ID'] . "',
				DOG_ID = '" . $_SESSION['dogID'] . "',
				ACTION = 'A6',
				COMMENT = ''";
	$LOGresult=mysql_query($LOGqry);
?>