<?php 
	//Include database connection details
	require_once('config.php');
	require_once('function.php');
	
	print "<script language='JavaScript' type='text/javascript'>
			function Check() {
				if(document.LoginForm.login.value == '') { 
					alert('Nem adtál meg e-mail címet');
					return false;
				}
				if(document.LoginForm.password.value == '') { 
					alert('NEM adtál meg jelszót!');
					return false;
				}
			}
		</script>
	
	<div id='loginbox' class='right border'>
			<h4>Belépés</h4>
			<form name='LoginForm' method='post' action='' onsubmit='return Check()' >
			<table width='210' border='0' align='center' cellpadding='2' cellspacing='0'>
    			<tr>
      				<td ><p>Email:</p></td>
      				<td ><input name='login' type='text' size='23' class='textfield' id='login' value='";
					if (isset($_SESSION['login'])){ print $_SESSION['login']; }
					print "' /></td>
    			</tr>
    			<tr>
      				<td><p>Jelszó:</p></td>
      				<td><input name='pass' type='password' size='23' class='textfield' id='passw' /></td>
    			</tr>
    			<tr height=\"50px\">
      				<td>&nbsp;</td>
      				<td align='right'><input type='submit' name='Login' value='Belépés' class='button' /></td>
    			</tr>
  			</table>
		</form>
		</div>";
		
	if (isset($_POST['Login'])) {
		//Sanitize the POST values
			$login = clean($_POST['login']);
			$pass = clean($_POST['pass']);
	
		//Create query
			$qry="SELECT * FROM users WHERE EMAIL='$login' AND PASSWORD='".md5($pass)."'";
			$result=mysql_query($qry);
	
		//Check whether the query was successful or not
			if($result) {
				if(mysql_num_rows($result) == 1) {

						$member = mysql_fetch_assoc($result);
						//Login Successful
							$_SESSION['SESS_MEMBER_ID'] = $member['USER_ID'];
							$_SESSION['SESS_NAME'] = $member['NAME'];
							$_SESSION['SESS_MEMBER_PASS'] = $member['PASSWORD'];
							$_SESSION['SESS_EMAIL'] = $member['EMAIL'];
							$_SESSION['RIGHTS'] = $member['RIGHTS'];
							$_SESSION['SESS_LOGIN_TIME'] = time();
							$_SESSION['LOGON'] = true;
							$_SESSION['IP_ADDRESS'] = $_SERVER['REMOTE_ADDR'];
							$login_date = ActTime();
							session_write_close();
							//Belépés idejének mentése
							mysql_query(" UPDATE users SET LAST_LOGIN = '".$login_date."', IP_ADDRESS = '".$_SESSION['IP_ADDRESS']."' WHERE USER_ID = '".$_SESSION['SESS_MEMBER_ID']."'");
							print "<script type='text/javascript' language='javascript'>
									location.href='member-index.php';
								   </script>";
				}
				else {
				//Login failed
					$error = "Hibás felhasználónév vagy jelszó"; $errflag = true;
				}
			}
			else {
				die("Query failed");
			}
	}
	
//HIBAÜZENET KIÍRÁSA
	if( isset($_SESSION['MSG'])) {
		DropMSG(); //$_SESSION['MSG']
}
		
//If there are input validations, redirect back to the registration form
	if(isset($errflag)) {
		$_SESSION['MSG'] = $error;
		$_SESSION['login'] = $_POST['login'];
		session_write_close();
		ReLoad();
		exit();
	}
?>