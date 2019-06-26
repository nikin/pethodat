<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');

print "<table cellpadding='0' cellspacing='0' border='0' id='ddog' width='1000'>
			<thead>
				<tr height='40' class=\"center\">
					<th width='100'>Nyomtat</th>
					<th width='100'>Sorszám</th>
					<th width='200'>Kutya Neve</th>
					<th width='80'>Ivar</th>
					<th>Szőrzet</th>
					<th>Szinezet</th>
					<th>Születési Idő</th>
				</tr>
			</thead>
			<tbody align='center'>";
$Aqry="SELECT * FROM dogs WHERE STATUS = 'ST2'";
$Aresult=mysql_query($Aqry);
	if(mysql_num_rows($Aresult) > 0) {
		while ($dogs = mysql_fetch_assoc($Aresult)) {
			print "<tr height='35'>
					<td><input name='' type='checkbox' value='' /></td>		
					<td>".$dogs['DOG_ID']."</td>
					<td><a href=\"member-index.php?oldal=adatlap&ID=".$dogs['DOG_ID']."\">".$dogs['DOG_NAME']."</td>
					<td>".DataName($dogs['SEX'])."</td>
					<td>".DataName($dogs['HAIR'])."</td>
					<td>".$dogs['COLOUR']."</td>
					<td>".$dogs['B_DATE']."</td>
					</tr>";
		}
	}
print "</tbody></table>&nbsp;";
?>
</body>
</html>