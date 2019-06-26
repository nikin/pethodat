<script type="text/javascript" charset="utf-8">
				$(document).ready(function() {
					$('#archive').dataTable( {
						"aaSorting": [[ 4, "desc" ]]} );
					
				} );
</script> 
<?php
//Include database connection details
	require_once('auth.php');
	require_once('function.php');

print "<table cellpadding='0' cellspacing='0' border='0' id='archive' width='100%'>
			<thead>
				<tr height='40' class=\"center\">
					<th width='100'>Sorszám</th>
					<th width='200'>Kutya Neve</th>
					<th width='80'>Ivar</th>
					<th>Örökbeadás Ideje</th>
					<th>Örökbefogadó</th>
				</tr>
			</thead>
			<tbody align='center'>";
$Aqry="SELECT DOG_ID, DOG_NAME, SEX, ADOPT_DATE, OWNER_ID FROM archive_dogs WHERE STATUS = 'ST4'";
$Aresult=mysql_query($Aqry);
	if(mysql_num_rows($Aresult) > 0) {
		while ($dogs = mysql_fetch_assoc($Aresult)) {
			print "<tr height='35'>
					<td>".$dogs['DOG_ID']."</td>
					<td><a href=\"member-index.php?oldal=adatlap&ID=".$dogs['DOG_ID']."\">".$dogs['DOG_NAME']."</td>
					<td>".DataName($dogs['SEX'])."</td>
					<td>".$dogs['ADOPT_DATE']."</td>
					<td title=\"".OwnerData($dogs['OWNER_ID'])."\">".OwnerName($dogs['OWNER_ID'])."</td>
					</tr>";
		}
	}
print "</tbody></table>&nbsp;";
?>
</body>
</html>