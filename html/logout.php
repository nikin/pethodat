<?php
//Nyelv beállítása
	session_start();
	session_destroy();  
	session_regenerate_id();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<title>Kilépő Oldal</title>
</head>
<html>
	<body>
		<h1>Sikeres kijelntkezés</h1>
        <a href="index.php">Vissza a belépőoldalra</a>
	</body>
</html>