<?php
//Include database connection details
	require_once('auth.php');
	require_once('function.php');
	
	$qry = "SELECT * FROM video";
	$result = mysql_query($qry);
	
	while ($TMP = mysql_fetch_assoc($result)){
		print $TMP['LINK']." -> ";
		$Link = $TMP['LINK'];
		$Lk = rtrim($Link,"&");
		print $Lk."<br>";
	}
?>