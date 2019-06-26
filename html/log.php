<?php
//Include database connection details
	require_once('auth.php');
	require_once('function.php');

	$dogID = $_GET['ID'];

// Adatbázis elérése
	$qry="SELECT * FROM log WHERE DOG_ID='".$dogID."'";
	$result=mysql_query($qry);
	if (mysql_num_rows($result) == 0 ){
		$qry="SELECT * FROM archive_log WHERE DOG_ID='".$dogID."'";
		$result=mysql_query($qry);
	}
		
	while ($Log = mysql_fetch_assoc($result)) {
		print "<b>" . $Log['DATE'] . "</b> - " . dataname($Log['ACTION']) . " / " . Username($Log['USER_ID']) . " " . Ownername($Log['OWNER_ID']) . "<br>";
	}
	
	//print "<div class='floatr'>".DogName($dogID)."</div>";
?>