<?php
//Include database connection details
	require_once('autha.php');
	
// Adatbázis elérése
$qry="SELECT * FROM users";
$result=mysql_query($qry);

print "<div>&nbsp;</div>
		<div class=\"border\">
		<FORM>
		<INPUT TYPE='button' class=\"newuser\" title='Új felhasználó létrehozása' onClick=\"popup('Newuser')\">
		</FORM>";
		
// Táblázat fejléc
print "<table cellpadding='0' cellspacing='0' border='0' id='tabla' width='98%' class=\"floatc\">
			<thead>
				<tr height=\"40\" height='20'  class=\"center\">
					<th width='60'>USER ID</th>
					<th width='150'>Felhasználó Neve</th>
					<th width='190'>E-mail cím</th>
					<th width='100'>Jogosultság</th>
					<th width='150'>Utolsó belépés</th>
				</tr>
			</thead>
			<tbody>";


	if(mysql_num_rows($result) > 0) {
			while ($users = mysql_fetch_assoc($result)) {
				print "<tr height=\"35\"  class=\"center\">
					<td>".$users['USER_ID']."</td>
					<td><a href='member-index.php?oldal=user&ID=".$users['USER_ID']."' title='Szerkeszt'>".$users['NAME']."</td>
					<td>".$users['EMAIL']."</td>
					<td>";
					if ($users['RIGHTS']=='1') {
						print "Admin";}
					elseif ($users['RIGHTS']=='0'){ print "User";}
					elseif ($users['RIGHTS']=='2'){ print "Root";}
					print "</td>
					<td>".$users['LAST_LOGIN']."</td>
					</tr>";
			}
		}
print "</tbody></table></div>";

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
		
		function CheckNewUser() {
			if(document.NewUser.name.value == '') { 
				alert('Add meg az új felhasználó nevét!');
				return false;
			}
			if(document.NewUser.email.value == '') { 
				alert('Add meg az új felhasználó email címét');
				return false;
			}
			if (!(ChkEmail(document.NewUser.email.value))) { 
				alert('Nem megfelelő E-mail formátum');
				return false;
			}
			if(document.NewUser.password.value == '') { 
				alert('Add meg az új felhasználó jelszavát');
				return false;
			}
		}
		</script>";
	
	if (isset($_POST['SaveUser'])) {  // MENTÉS gomb lenyomására mentés
		$name = clean($_POST['name']);
		$email = clean($_POST['email']);
		$rights = $_POST['jog'];
		$password = clean($_POST['password']);
		
		$user_check = mysql_query("SELECT * FROM users WHERE EMAIL = '".$email."'");  // Regisztrált E-MAIL cím ellenőrzése
		if($user_check) {
			if(mysql_num_rows($user_check) > 0) {
				print "Már regisztrált email cím!!";
				print "Nincs Mentve";
			}
			else {
				//Adatok mentésa az adatbázisba
				$qry = "INSERT INTO users SET
						NAME = '" .  $name . "',
						EMAIL = '" .  $email . "',
						RIGHTS = '" .  $rights . "',
						PASSWORD = '" .  mysql_real_escape_string(md5($password)) . "'";
				$result = @mysql_query($qry);
				print "Sikeres Mentés
				<script language=\"javascript\" type=\"text/javascript\">
					location.href='?oldal=admin'
					</script>";
			}
		}
	}
	
	// FORM rajzolása
	
	print "<div id='Newuser' class=\"floatl border mh8\" style='display:none'>
			Új felhasználó rögzítése
			<form action='' method='post' name='NewUser' id='NewUser' onsubmit='return CheckNewUser()' >
			<table width='400' class='floatc'>
					<tr height='30' class='p2'>
						<td width='200'>Felhasználó neve:</td>
						<td width='200'><input name=\"name\" type=\"text\" size=\"35\" maxlength=\"40\"/></td>
					</tr>
					<tr height='30' class='p2'>
						<td width='200'>E-mail cím:</td>
						<td width='200'><input name=\"email\" type=\"text\" size=\"35\" maxlength=\"40\" /></td>
					</tr>
					<tr height='30' class='p2'>
						<td width='200'>Jogosultság:</td>
						<td width='200'><select class='textfield' name='jog' id='jog'>
											<option value='0'>".DataName(R0)."</option>
											<option value='1'>".DataName(R1)."</option>
											<option value='2'>".DataName(R2)."</option>
						</td>
					</tr>
					<tr height='30' class='p2'>
						<td width='200'>Jelszó:</td>
						<td width='200'><input name=\"password\" type=\"text\" size=\"15\" maxlength=\"10\"</td>
					</tr>
					<tr height='40'>
								<td colspan='2' class='center'>
									<label><input type='button' name='back' class='bcancel' value='' onclick=\"javascript:location.href='?oldal=admin'\" title='Mégsem' /> </label>
       								<label><input type='submit' name='SaveUser' class='bsave' value='' title='Mentés' /> </label>
								</td>
      						</tr>
				</table>
				</form>
		</div>";
?>