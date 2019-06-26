<?php
	//Ido ido meghatározása
	$curr_time = time();
	$_SESSION['SESS_LOG_TIME'] = floor($curr_time)-floor($_SESSION['SESS_LOGIN_TIME']);
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_LOGIN_TIME']) || !isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '') || ($_SESSION['RIGHTS'] != 2)) {
		print "<h1>Nincs jogosultságod az oldal megtakíntéséhez!</h1>";
		print "Time" + $_SESSION['SESS_LOGIN_TIME'];
		exit();
	}
?>