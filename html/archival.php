<?php
require_once('auth.php');
require_once('function.php');

$qry="SELECT DOG_ID FROM archive_dogs WHERE STATUS = 'ST5'";
$result=mysql_query($qry);

while ($adopt = mysql_fetch_assoc($result)) {
	$dogID = $adopt['DOG_ID'];
	
	$ArDqry="INSERT INTO archive_medical SELECT * FROM medical WHERE DOG_ID = '".$dogID."'";
	$ArDresult=mysql_query($ArDqry);
	$ArDelqry="DELETE FROM medical WHERE DOG_ID = '".$dogID."'";
	$ArDelresult=mysql_query($ArDelqry);
	print "ADAT arhiválás: ".$dogID." OK!<br>";
	
	/*$ArLogqry="INSERT INTO archive_log SELECT * FROM log WHERE DOG_ID = '".$dogID."'";
	$ArLogresult=mysql_query($ArLogqry);
	$ArLogDelqry="DELETE FROM log WHERE DOG_ID = '".$dogID."'";
	$ArLogDelresult=mysql_query($ArLogDelqry);
	print "LOG arhiválás: ".$dogID." OK!<br>";*/
}
?>