<?php
//Include database connection details
	require_once('auth.php');
	
// User azonosítása
	$ownerID=$_GET['ID'];
	if (isset($_SESSION['MSG'])) {
		DropMSG();}
	
		// Adatbázis elérése
		$qry="SELECT * FROM owner WHERE OWNER_ID='".$ownerID."'";
		$result=mysql_query($qry);
		$Owner = mysql_fetch_assoc($result);
		
		if(mysql_num_rows($result) == 0) { // Ha nem találja a OWNER_ID-t akkor NINCS ILYEN USER
			print "Nincs ilyen user
			<a href=\"member-index.php?oldal=o-admin\">Vissza</a>";
		}
		else {
			if (isset($_POST['AddOwner'])) {  // MENTÉS gomb lenyomására mentés
				$Name = clean($_POST['Name']);
				$Szigsz = clean($_POST['Szigsz']);
				$Email = clean($_POST['Email']);
				$Tel = clean($_POST['Tel']);
				$Pcode = clean($_POST['Pcode']);
				$City = clean($_POST['City']);
				$Address = clean($_POST['Address']);
				$Comment = clean($_POST['Comment']);
			
				$SaveQRY = "UPDATE owner SET
									NAME = '" .  $Name . "',
									SZIGSZ = '" .  $Szigsz . "',
									EMAIL = '" .  $Email . "',
									TEL = '" .  $Tel . "',
									P_CODE = '" .  $Pcode . "',
									CITY = '" .  $City . "',
									ADDRESS = '" .  $Address . "',
									COMMENT = '" .  $Comment . "'
								WHERE OWNER_ID = '".$ownerID."'";
				$SAVEresult = @mysql_query($SaveQRY);
				
				$OWqry="SELECT * FROM owner ORDER BY NAME";
				$OWresult=mysql_query($OWqry);
				print "<script language=\"javascript\" type=\"text/javascript\">
						location.href='?oldal=o-admin'
						</script>";
			}
			
			print "&nbsp;
			<div id='NewOwner' class=\"floatl border mh8\" style='display:block'>
			Új örökbefogadó rögzítése
			<form action='' method='post' name='AddForm' id='AddForm' onsubmit='return CheckAddOwner()' >
			<table id=\"adatlap\" width=\"600\" class='floatc'>
				<tr>
					<td class=\"right\"><b>Név:</b></td>
					<td><input name=\"Name\" type=\"text\" size=\"35\" maxlength=\"30\" value=\"".$Owner['NAME']."\"";
					if ($_SESSION['RIGHTS'] == '1'){print "disabled";}
					print" /></td>
					<td class=\"right\"><b>Szig.Sz.:</b></td>
					<td><input name=\"Szigsz\" type=\"text\" size=\"15\" maxlength=\"10\" value=\"".$Owner['SZIGSZ']."\" /></td>
				</tr>
				<tr>
					<td class=\"right\"><b>E-mail:</b></td>
					<td width=\"50\" class=\"right\"><input name=\"Email\" type=\"text\" size=\"45\" maxlength=\"40\" value=\"".$Owner['EMAIL']."\" /></td>
					<td class=\"right\"><b>Telefon:</b></td>
					<td colspan=\"3\"><input name=\"Tel\" type=\"text\" size=\"25\" maxlength=\"20\" value=\"".$Owner['TEL']."\" /></td>
				</tr>
				<tr>
					<td class=\"right\"><b>Irányítószám:</b></td>
					<td width=\"50\"><input name=\"Pcode\" type=\"text\" size=\"5\" maxlength=\"4\" value=\"".$Owner['P_CODE']."\" /></td>
					<td class=\"right\"><b>Város:</b></td>
					<td colspan=\"3\"><input name=\"City\" type=\"text\" size=\"25\" maxlength=\"20\" value=\"".$Owner['CITY']."\" /></td>
				</tr>
				<tr>
					<td class=\"right\"><b>Címsor:</b></td>
					<td colspan=\"3\"><input name=\"Address\" type=\"text\" size=\"45\" maxlength=\"40\" value=\"".$Owner['ADDRESS']."\" ></input></td>
				</tr>
				<tr>
					<td class=\"right\"><b>Megjegyzés:</b></td>
					<td class=\"pl textf\" colspan=\"3\"><textarea name=\"Comment\" cols=\"70\" rows=\"3\" resize=\"none\" >".$Owner['COMMENT']."</textarea></td>
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
		}
?>