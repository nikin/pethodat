<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu-hu" lang="hu-hu" dir="ltr" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<title>Si&oacute;foki &Aacute;llatmenhely Adatb&aacute;zis</title>
</head>

<body>
<?php
//Include database connection details
	require_once('config.php');
	require_once('function.php');

	$ID = $_GET['ID'];
	$Vqry = "SELECT * FROM video WHERE DOG_ID='".$ID."'";
	$Vresult = mysql_query($Vqry);
	
	while ($Video = mysql_fetch_assoc($Vresult)) {
		$link = strstr($Video['LINK'], 'v=');
		$link = substr($link,2);
		$link = rtrim($link,'&');
		print" <iframe width=\"560\" height=\"315\" src=\"http://www.youtube.com/embed/".$link."\" frameborder=\"0\" allowfullscreen></iframe>";
	}
?>
</body>