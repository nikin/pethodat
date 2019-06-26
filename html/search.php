<?php
//Include database connection details
	require_once('auth.php');
//Clear Dog ID
	unset($_SESSION['dogID']);

print "<div>&nbsp;</div>
		<div id=\"tabs\">
				<ul>
					<li><a href=\"#tabs-1\">Keresés</a></li>
					<li><a href=\"archive.php\">Örökbe fogadott kutyák</a></li>	
					<li><a href=\"ddog.php\">Elpusztult kutyák</a></li>
				</ul>
				
			<div id=\"tabs-1\">
			
			<table class=\"fejl floatc\" cellpadding='0' cellspacing='0' border='0' id='tabla' width='100%'>
			<thead>
				<tr height='40' class=\"center\">
					<th width='100'>Sorszám</th>
					<th width='200'>Kutya Neve</th>
					<th width='80'>Ivar</th>
					<th>Szőrzet</th>
					<th>Szinezet</th>
					<th>Születési Idő</th>
					<th>Befogás Helye</th>
					<th>Befogás Ideje</th>
					<th>Státusz</th>
				</tr>
			</thead>
			<tbody class='center'>";
$qry="SELECT DOG_ID, DOG_NAME, SEX, HAIR, COLOUR, B_DATE, BEF_PLACE, BEF_DATE, STATUS  FROM dogs WHERE STATUS NOT IN ('ST4','ST5')";
$result=mysql_query($qry);
	if(mysql_num_rows($result) > 0) {
		while ($dogs = mysql_fetch_assoc($result)) {
			print "<tr height='35' title=\"".$dogs['COMMENT']."\">
					<td>".$dogs['DOG_ID']."</td>
					<td><a href=\"member-index.php?oldal=adatlap&ID=".$dogs['DOG_ID']."\">".$dogs['DOG_NAME']."</td>
					<td>".DataName($dogs['SEX'])."</td>
					<td>".DataName($dogs['HAIR'])."</td>
					<td>".$dogs['COLOUR']."</td>
					<td>".$dogs['B_DATE']."</td>
					<td>".$dogs['BEF_PLACE']."</td>
					<td>".$dogs['BEF_DATE']."</td>
					<td>".DataName($dogs['STATUS'])."</td>
					</tr>";
		}
	}
	print "</tbody></table>&nbsp;</div>

<div id=\"tabs-2\"></div>

<div id=\"tabs-3\"></div>";
?>