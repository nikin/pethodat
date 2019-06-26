<?php
//Include database connection details
	require_once('auth.php');
	
// Adatbázis elérése
$qry="SELECT * FROM owner";
$result=mysql_query($qry);

print "<div>&nbsp;</div>
		<div class=\"border\">";
		if ($_SESSION['RIGHTS'] == '1' or $_SESSION['RIGHTS'] == '2'){
		print "<FORM>
		<INPUT TYPE='button' class=\"newuser\" title='Új örökbefogadó rögzítése' onClick=\"popup('NewOwner')\">
		</FORM>";
		}
		
// Táblázat fejléc
print "<table cellpadding='0' cellspacing='0' border='0' id='tabla' width='98%' class=\"fejl floatc\">
			<thead>
				<tr height=\"40\" height='20'  class=\"center\">
					<th width='60'>OWNER ID</th>
					<th width='150'>Felhasználó Neve</th>
					<th width='190'>E-mail cím</th>
					<th width='100'>Város</th>
					<th width='150'>Cím</th>
					<th width='150'>Tel.</th>
				</tr>
			</thead>
			<tbody>";


	if(mysql_num_rows($result) > 0) {
			while ($owners = mysql_fetch_assoc($result)) {
				print "<tr height=\"35\"  class=\"center\">
					<td>".$owners['OWNER_ID']."</td>
					<td>";
					if ($_SESSION['RIGHTS'] == '1' or $_SESSION['RIGHTS'] == '2'){
						print "<a href='member-index.php?oldal=o-edit&ID=".$owners['OWNER_ID']."' title='Szerkeszt'>".$owners['NAME'];
					}
					else {
						print $owners['NAME'];
					}
					print "</td>
					<td>".$owners['EMAIL']."</td>
					<td>".$owners['CITY']."</td>
					<td>".$owners['ADDRESS']."</td>
					<td>".$owners['TEL']."</td>
					</tr>";
			}
		}
print "</tbody></table>&nbsp;</div>";

print"<script language='JavaScript' type='text/javascript'>
		function ChkEmail(strTemp) {
			var check = false;
			if (strTemp.length > 0) { 
				if (strTemp.indexOf('@') > 0) { 
					if (strTemp.indexOf('.') > 0 && strTemp.indexOf('.') < strTemp.length - 1) {
						check = true;
					}
				}
			}
			return check;
		}
		
		function CheckAddOwner() {
			if(document.AddForm.Name.value == ''){alert('Hiányzó adat: NÉV!');return false;}
			if(document.AddForm.Szigsz.value == ''){alert('Hiányzó adat: Szig.Sz.!');return false;}
			if(document.AddForm.Email.value == ''){alert('Hiányzó adat: E-MAIL!');return false;}
			if (!(ChkEmail(document.AddForm.email.value))){alert('Nem megfelelő E-mail formátum');return false;}
			if(document.AddForm.Tel.value == ''){alert('Hiányzó adat: TELEFONSZÁM!');return false;}
			if(document.AddForm.Pcode.value == ''){alert('Hiányzó adat: IRÁNYÍTÓSZÁM!');return false;}
			if(document.AddForm.City.value == ''){alert('Hiányzó adat: VÁROS!');return false;}
			if(document.AddForm.Address.value == ''){alert('Hiányzó adat: CÍM!');return false;}
		}
		</script>";
	
	if (isset($_POST['AddOwner'])) {  // MENTÉS gomb lenyomására mentés
		$Name = clean($_POST['Name']);
		$Szigsz = clean($_POST['Szigsz']);
		$Email = clean($_POST['Email']);
		$Tel = clean($_POST['Tel']);
		$Pcode = clean($_POST['Pcode']);
		$City = clean($_POST['City']);
		$Address = clean($_POST['Address']);
		$Comment = clean($_POST['Comment']);
	
		$SaveQRY = "INSERT INTO owner SET
							NAME = '" .  $Name . "',
							SZIGSZ = '" .  $Szigsz . "',
							EMAIL = '" .  $Email . "',
							TEL = '" .  $Tel . "',
							P_CODE = '" .  $Pcode . "',
							CITY = '" .  $City . "',
							ADDRESS = '" .  $Address . "',
							COMMENT = '" .  $Comment . "'";
		$SAVEresult = @mysql_query($SaveQRY);
		
		$OWqry="SELECT * FROM owner ORDER BY NAME";
		$OWresult=mysql_query($OWqry);
		print "Sikeres Mentés
				<script language=\"javascript\" type=\"text/javascript\">
					location.href='?oldal=o-admin'
					</script>";
	}
	
	// FORM rajzolása
	
	print "<div id='NewOwner' class=\"floatl border mh8\" style='display:none'>
			Új örökbefogadó rögzítése
			<form action='' method='post' name='AddForm' id='AddForm' onsubmit='return CheckAddOwner()' >
			<table id=\"adatlap\" width=\"600\" class='floatc'>
				<tr>
					<td class=\"right\"><b>Név:</b></td>
					<td><input name=\"Name\" type=\"text\" size=\"35\" maxlength=\"30\" /></td>
					<td class=\"right\"><b>Szig.Sz.:</b></td>
					<td><input name=\"Szigsz\" type=\"text\" size=\"15\" maxlength=\"10\" /></td>
				</tr>
				<tr>
					<td class=\"right\"><b>E-mail:</b></td>
					<td width=\"50\" class=\"right\"><input name=\"Email\" type=\"text\" size=\"45\" maxlength=\"40\" /></td>
					<td class=\"right\"><b>Telefon:</b></td>
					<td colspan=\"3\"><input name=\"Tel\" type=\"text\" size=\"25\" maxlength=\"20\" /></td>
				</tr>
				<tr>
					<td class=\"right\"><b>Irányítószám:</b></td>
					<td width=\"50\"><input name=\"Pcode\" type=\"text\" size=\"5\" maxlength=\"4\" /></td>
					<td class=\"right\"><b>Város:</b></td>
					<td colspan=\"3\"><input name=\"City\" type=\"text\" size=\"25\" maxlength=\"20\" /></td>
				</tr>
				<tr>
					<td class=\"right\"><b>Címsor:</b></td>
					<td colspan=\"3\"><input name=\"Address\" type=\"text\" size=\"45\" maxlength=\"40\"></input></td>
				</tr>
				<tr>
					<td class=\"right\"><b>Megjegyzés:</b></td>
					<td class=\"pl textf\" colspan=\"3\"><textarea name=\"Comment\" cols=\"70\" rows=\"3\" resize=\"none\"></textarea></td>
				</tr>
				<tr>
					<td colspan='4' class='center'>
									<label><input type='button' name='back' class='bcancel' value='' onclick=\"javascript:location.href='?oldal=o-admin'\" title='Mégsem' /> </label>
       								<label><input type='submit' name='AddOwner' class='bsave' value='' title='Mentés' /> </label>
								</td>
      						</tr>
				</table>
				</form>
		</div>";
?>