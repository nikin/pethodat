<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<html>
<body>
<?php
	session_start();
	
	print "	<h2>Lejárt a biztonsági időkorlát!!!</h2>
			<h3>Jelentkezz be újra</h3>";
	print "<div id=\"center\">";
	include ('login.php');
	print "</div>";
	session_destroy();
?>
</body>
</html>