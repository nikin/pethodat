<?php
//Include database connection details
	require_once('config.php');
	require_once('function.php');

	$ownerID = $_GET['ownerID'];
	$dogID = $_GET['dogID'];
	
	$qry="SELECT * FROM archive_dogs WHERE DOG_ID='".$dogID."'";
	$result=mysql_query($qry);
	$dog = mysql_fetch_assoc($result);
	
	$Oqry="SELECT * FROM owner WHERE OWNER_ID='".$ownerID."'";
	$Oresult=mysql_query($Oqry);
	$owner = mysql_fetch_assoc($Oresult);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/print.css" rel="stylesheet" type="text/css" />
<title>Örökbefogadási nyilatkozat</title>
</head>

<body>
<script>print();</script>
<div id="header">
	<div id="header_left">Siófoki  Állatvédő Alapítvány<br />Tel:  20/922-3562</div>
	<div id="header_right">Adószám: 19201649 – 2 - 14<br />Bankszámlaszám:  Erste Bank 11992505-05500598</div>
</div>
<div id="page">
	<h1>Örökbefogadási nyilatkozat</h1>
    <div class="justify">Alulírott <b><i><?php print $owner['NAME'].", ".$owner['P_CODE']." ".$owner['CITY']." ".$owner['ADDRESS']; ?></i></b> sz  alatti lakosa mai napon a Siófoki Állatvédő Alapítványtól örökbe fogadom a  következő állatot:</div>
  	<div id="dog_data"><b>
    	<table width="500px">
        	<tr>
            	<td width="150px" class="right">Neve:</td>
                <td colspan="3" width="350px"><i><?php print $dog['DOG_NAME'];?></i></td>
            </tr>
            <tr>
            	<td class="right">Fajtája:</td>
                <td colspan="3" ><i><?php print $dog['BREED'];?></i></td>
            </tr>
            <tr>
            	<td class="right">Színe:</td>
                <td><i><?php print $dog['COLOUR'];?></i></td>
                <td class="right">Neme:</td>
                <td><i><?php print dataname($dog['SEX']);?></i></td>
            </tr>
            <tr>
            	<td class="right">Chip szám:</td>
                <td colspan="3" ><i><?php print $dog['CHIP'];?></i></td>
           	</tr>
         </table></b>
	</div>
    <div id="data">
		<h3>Az  örökbefogadás feltételei:</h3>
		<ol>
  			<li>Az állatot megkötni nem  engedjük! Kennelben tartani rendszeres sétáltatás mellett lehet. <strong>Amennyiben  az ellenőrzés során kötve találjuk a kutyát, úgy az </strong><em>Alapítványnak </em><strong>joga  van azt visszavenni. </strong></li>
            <li>Az örökbefogadó  köteles biztosítani az állat lakhelyét bekerített területen, kutyaól vagy ennek  megfelelő épület vagy épületrész formájában. <strong>Hibás, hiányos kerítés nem  felel meg a feltételeknek. </strong></li>
			<li>Az örökbefogadó  köteles az állatot megfelelően táplálni és gondozni (féreghajtás, kullancs- és  bolhairtás), gondoskodni kell a kötelező védőoltások beadásáról és szükség  esetén orvosi ellátásról.</li>
			<li>Az Alapítvány  képviselőinek joguk van az állatot meglátogatni, az állat tartási körülményeit  ellenőrizni.<br /><strong>Nem  megfelelő tartás vagy bánásmód esetén az </strong><em>Alapítványnak </em><strong>joga van az állatot  visszavenni az örökbefogadótól. </strong></li>
			<li>Kölykök  örökbefogadása esetén a 8 hónapos kort betöltött szukákat előzetes időpont  egyeztetés után ivartalanításra vissza kell hozni.</li>
			<li><strong>A  kutyát az örökbefogadó nem ajándékozhatja tovább, nem adhatja át tartásra  senkinek! Amennyiben nincs lehetősége az állat további tartására, úgy minden  esetben vissza kell hoznia az </strong><em>Alapítványhoz</em><strong>. </strong></li>
			<li><strong>Ha  az örökbefogadó a feltételeket súlyosan megszegi, az </strong><em>Alapítvány </em><strong>feljelentéssel  él. </strong></li>
        </ol>
		<h4><i>A  fenti feltételeket büntetőjogi felelősségem tudatában tudomásul veszem és  gondoskodom betartásukról:</i></h4>
        <h4>Siófok,  <?php print $dog['ADOPT_DATE'];?></h4>
            
        <table width="600px" class="center">
        	<tr>
            	<td width="50%">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
                <td width="50%">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
            </tr>
			<tr>
            	<td>Örökbefogadó</td>
                <td>Siófoki Állatvédő Alapítvány</td>
            </tr>
            <tr>
            	<td>Szig. sz.: <?php print $owner['SZIGSZ'];?></td>
                <td></td>
            </tr>
         </table>
         <br />
         <b><i>Az Alapítvány készségesen ad tanácsot az  örökbefogadónak, amennyiben az állattal kapcsolatban bármilyen probléma adódik,  vagy előzetes egyeztetés után visszafogadja az állatot.</i></b>
  </div>
</div>
</body>
</html>