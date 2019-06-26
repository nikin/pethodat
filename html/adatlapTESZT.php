<?php

//Include database connection details
	require_once('auth.php');
	
//Get DOG_ID
	$dogID = $_GET['ID'];
	
	if (isset($dogID)) { //Ha van DOG_ID 
		
		$_SESSION['dogID'] = $dogID;
		
		if(mysql_num_rows($result) == 0) { // Ha nem találja a DOG_ID-t akkor NINCS ILYEN KUTYA
			print "Nincs ilyen kutya";
		}
		else {
			print"
			<div>&nbsp;</div>
			<div id=\"tabs\">
				<ul>
					<li><a href=\"data_uj.php\">Kutya Adatai</a></li>
					<li><a href=\"medical.php\">Orvosi Karton</a></li>
					<li><a href=\"owner.php\">Örökbefogadó adatai</a></li>";
					if ($_SESSION['RIGHTS'] == '1' or $_SESSION['RIGHTS'] == '2'){
					print "<li><a href=\"log.php\">Eseménynapló</a></li>";
					}
				print "</ul>
				
			<div id=\"tabs-1\"></div>";
	
	// --------------------- ADATOK VÉGE!! ---------------------
	
	
	// --------------------- ORVOSI ADATOK ---------------------
	
	print "<div id=\"tabs-2\"></div>"; 	// --------------------- medical.php ---------------------
	
	// --------------------- ORVOSI ADATOK VÉGE!! ---------------------
	
	
	// --------------------- ÖRÖKBEFOGADÓ ADATI VÉGE!! ---------------------
	
	print"<div id=\"tabs-3\"></div>"; // --------------------- owner.php ---------------------
	
	// --------------------- ÖRÖKBEFOGADÓ ADATI VÉGE!! ---------------------

	print"<div id=\"tabs-4\"></div>"; // --------------------- log.php ---------------------
print "</div>";
		}
	}
	else { //HA nincs DOG_ID
		print "Hiányzó kutya azonosító!!";
	}
	
	
?>