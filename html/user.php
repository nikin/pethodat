<?php
//Include database connection details
	require_once('autha.php');
	
// User azonosítása
	$userID=$_GET['ID'];
	if (isset($_SESSION['MSG'])) {
		DropMSG();}
	
		// Adatbázis elérése
		$qry="SELECT * FROM users WHERE USER_ID='".$userID."'";
		$result=mysql_query($qry);
		$user = mysql_fetch_assoc($result);
		
		if(mysql_num_rows($result) == 0) { // Ha nem találja a USER_ID-t akkor NINCS ILYEN USER
			print "Nincs ilyen user
			<a href=\"member-index.php?oldal=admin\">Vissza</a>";
		}
		else {
			//Jelszó módosítás
				if (isset($_POST['ChangePassword'])) {
				//Sanitize the POST values
					$npass = clean($_POST['newpass']);
					$cnpass = clean($_POST['cnewpass']);
					
				//Adatok mentésa az adatbázisba
					mysql_query(" UPDATE users SET PASSWORD = '".mysql_real_escape_string(md5($npass))."' WHERE USER_ID = '".$userID."'");
							$_SESSION['SESS_MEMBER_PASS'] = md5($npass);
							$_SESSION['MSG'] = "A jelszó megváltozott!";
							print "<script>
										location.reload();										
									</script>";
				}
				
				//Jogosultság módosítás
				if (isset($_POST['ChangeRights'])) {
				//Sanitize the POST values
					$newjog = clean($_POST['newjog']);
				
					
				//Adatok mentésa az adatbázisba
					mysql_query(" UPDATE users SET RIGHTS = '".$newjog."' WHERE USER_ID = '".$userID."'");
					$_SESSION['MSG'] = "A jogosultság megváltozott!";
					print "<script>location.reload();</script>";
				}
				
			print "<script>
		function CheckPassword() {
			if(document.ChangePassword.newpass.value.length < 6) {
				alert('Túl rövid jelszó! Min. 6 karakter!');
				return false;
			}
			if(document.ChangePassword.newpass.value != document.ChangePassword.cnewpass.value) {
				alert('Nem eggyező jelszópáros');
				return false;
			}
		}
			$(document).keyup(function(e) {
			if (e.keyCode == 27) {
				ClosePopup('Email');
				ClosePopup('Rights');
				ClosePopup('Password');
				 }   // esc
		});
		</script>";
		print "<div>&nbsp;</div>
		<div id='Profile' class=\"border pl\">
				<table width='400' class='floatc'
					<tr>
						<td width='200'>Felhasználó neve:</td>
						<td width='200'>".$user['NAME']."</td>
					</tr>
					<tr>
						<td width='200'>E-mail cím:</td>
						<td width='200'><a href=\"javascript:popup('Email')\">".$user['EMAIL']."</a></td>
					</tr>
					<tr>
						<td width='200'>Jogosultság:</td>
						<td width='200'>";
							if ($user['RIGHTS']=='1') {print "<a href=\"javascript:popup('Rights')\">Admin</a>";}
							elseif ($user['RIGHTS']=='0') { print "<a href=\"javascript:popup('Rights')\">User</a>";}
							elseif ($user['RIGHTS']=='2') { print "<a href=\"javascript:popup('Rights')\">Root</a>";}
						print "</td>
					</tr>
					<tr>
						<td width='200'>Jelszó:</td>
						<td width='200'><a href=\"javascript:popup('Password')\">Módosítás</a></td>
					</tr>
					<tr>
						<td colspan='2' class='right'><a href=\"member-index.php?oldal=admin\">Vissza</a></td>
					</tr>
				</table>
				</div>
				
			<div id='Email' class='floatl border mh8' style='display:none'>
				E-mail cím  módosítása
    			<form action='' method='post' name='ChangeEmail' id='ChangeEmail'  onsubmit='return CheckEmail()'>
    				<table width='550'>    
						<tr height='30' class='p2'>
					        <td colspan='2'>Jelenlegi E-mail cím: <b>".$user['EMAIL']."</b></td>
						</tr>
      					<tr height='30' class='p2'>
					        <td width='170' class='right'><p>Új email cím:</p></td>
					        <td width='380' class='pl'><label><input type='text' name='newemail' id='newemail' class='textfield' size='50' value='".$_SESSION['newemail']."' /></label></td>
						</tr>
      					<tr height='30' class='p2'>
					        <td class='right'><p>Új E-mail cím még egyszer:</p></td>
					        <td class='pl'><label><input type='text' name='cnewemail' id='cnewemail' class='textfield' size='50' value='".$_SESSION['cnewemail']."' /></label></td>
						</tr>
						<tr height='40'>
							<td colspan='2' class='center'>
								<label><input type='button' name='back' id='back' value='' class='bcancel' onclick=\"javascript:popup('Email')\" title='Mégsem' /> </label>
								<label><input type='submit' name='ChangeMail' value='' class='bsave' title='Módosít' /> </label>
							</td>
						</tr>
					</table>	
				</form>
			</div>
			
			<div id='Password' class=\"floatl border mh8\" style='display:none'>
				Jelszó módosítása
						<form action='' method='post' name='ChangePassword' id='ChangePassword'  onsubmit='return CheckPassword()'>
    					<table width='550'>
							<tr height='50' class='p2'>
								<td class='right'><p>Új jelszó:</p></td>
								<td class='pl'><label><input type='password' name='newpass' id='newpass' class='textfield' size='50' /></label></td>
							</tr>
							<tr height='50' class='p2'>
								<td class='right'><p>Új jelszó még egyszer:</p></td>
								<td class='pl'><label><input type='password' name='cnewpass' class='textfield' size='50' /></label></td>
							</tr>
							<tr height='40'>
								<td colspan='2' class='center'>
									<label><input type='button' name='back' class='bcancel' value='' onclick=\"javascript:popup('Password')\" title='Mégsem' /> </label>
       								<label><input type='submit' name='ChangePassword' class='bsave' value='' title='Módosít' /> </label>
								</td>
      						</tr>
  						</table>
					</form>
			</div>
			
			<div id='Rights' class=\"floatl border mh8\" style='display:none'>
				Jogosultság módosítása
                	<div>
						<form action='' method='post' name='ChangeRights' id='ChangeRights'>
    					<table width='300'>
							<tr height='50' class='p2'>
								<td class='right'><p>Jogosultság:</p></td>
								<td class='pl'><select class='textfield' name='newjog' id='newjog'>";
           							for ($i=0; $i<=2; $i++) {
										if ($i == $user['RIGHTS']) {
											print "<option value='".$i."' selected>".DataName("R".$i)."</option>";
										}
										else {
											print "<option value='".$i."'>".DataName("R".$i)."</option>";
										}
									}
									print"
            					</select></td>
							</tr>
							<tr height='40'>
								<td colspan='2' class='center'>
									<label><input type='button' name='back' class='bcancel' value='' onclick=\"javascript:popup('Rights')\" title='Mégsem' /> </label>
       								<label><input type='submit' name='ChangeRights' class='bsave' value='' title='Módosít' /> </label>
								</td>
      						</tr>
  						</table>
						</form>
  					</div>
				</div>
			</div>";

		}
?>