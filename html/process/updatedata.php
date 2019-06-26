<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
	$dog_name = clean($_POST['dog_name']);
	$dog_ID = clean($_POST['dogID']);
	$breed = clean($_POST['breed']);
	$sex = clean($_POST['sex']);
	$hair = clean($_POST['hair']);
	$colour = clean($_POST['colour']);
	$bdate = clean($_POST['bdate']);
	$estimated = clean($_POST['estimated']);
	$marm = clean($_POST['marm']);
	$chip = clean($_POST['chip']);
	$bef_date = clean($_POST['bef_date']);
	$bef_place = clean($_POST['bef_place']);
	$bef_cond = clean($_POST['bef_cond']);
	$charact = clean($_POST['charact']);
	$book_nbr = clean($_POST['book_nbr']);
	$webID = clean($_POST['LinkGroup']);
	$link = clean($_POST['Link']);
		
	$pattern = "http://";
    $replacement = '';
    $link = str_replace($pattern, $replacement, $link);
	
	if ($webID == 'AUTO'){
		$web = 'AUTO';
	}
	else {
		if ($link == ''){
			$web = 'AUTO';
		}
		else{
			$web = $link;
		}
	}
	
	if ($estimated == 'true'){
		$estimated = 1;
	}
	else {
		$estimated = 0;
	}
	
	$qry="SELECT * FROM dogs WHERE DOG_ID='".$dog_ID."'";
	$result=mysql_query($qry);
	if (mysql_num_rows($result) == 0 ){
		$dogT = "archive_dogs";
		$logT = "archive_log";
	}
	else{
		$dogT = "dogs";
		$logT = "log";
	}
	
	// Adatbázis elérése
	$UPqry="UPDATE ".$dogT." SET
			DOG_NAME = '" .  $dog_name . "',
			BREED = '" .  $breed . "',
			SEX = '" .  $sex . "',
			HAIR = '" .  $hair . "',
			COLOUR = '" .  $colour . "',
			B_DATE = '" .  $bdate . "',
			ESTIMATED = '" .  $estimated . "',
			MARM = '" .  $marm . "',
			CHIP = '" .  $chip . "',
			BOOK_NBR = '" .  $book_nbr . "',
			BEF_DATE = '" .  $bef_date . "',
			BEF_PLACE = '" .  $bef_place . "',
			BEF_COND = '" .  $bef_cond . "',
			CHARACT = '" .  $charact . "',
			WEB = '" .  $web . "'
			WHERE DOG_ID = '" . $dog_ID . "'";
	$LOGqry = "INSERT INTO ".$logT." SET
			USER_ID = '" . $_SESSION['SESS_MEMBER_ID'] . "',
			DOG_ID = '" . $dog_ID . "',
			ACTION = 'A2',
			COMMENT = ''";
	
	$UPresult=mysql_query($UPqry);
	$LOGresult=mysql_query($LOGqry);
	print "<script>
				window.location.href='http://siofokiallatvedo.hu/pethodat/member-index.php?oldal=adatlap&ID=". $dog_ID . "';
			</script>";
?>