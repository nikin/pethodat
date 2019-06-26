<?php

	
	require_once('config.php');
	
	//Ido ido meghatározása
	$curr_time = time();
	$_SESSION['SESS_LOG_TIME'] = floor($curr_time)-floor($_SESSION['SESS_LOGIN_TIME']);

	//Check IP address
	$qry="SELECT IP_ADDRESS FROM users WHERE USER_ID='".$_SESSION['SESS_MEMBER_ID']."'";
	$result=mysql_query($qry);
	$member = mysql_fetch_assoc($result);
	if(!isset($_SESSION['IP_ADDRESS']) || $member['IP_ADDRESS'] != $_SERVER['REMOTE_ADDR'] || $_SESSION['IP_ADDRESS'] != $_SERVER['REMOTE_ADDR']) {
		print "<h2>Nincs jogosultságod az oldal megtekíntéséhez!!!</h2>";
		print "<div id=\"center\">";
			include ('login.php');
		print "</div>";
		exit();}
		
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_LOGIN_TIME']) || !isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		print "<h2>Nincs jogosultságod az oldal megtekíntéséhez!!!x</h2>";
		print "<div id=\"center\">";
			include ('login.php');
		print "</div>";
		exit();
	}
?>