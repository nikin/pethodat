<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
	$dogID = $_GET['ID'];
	$Link = $_GET['Link'];
	
	$pattern = "http://";
    $replacement = '';
    $Link = str_replace($pattern, $replacement, $Link);
	
	$pattern = "https://";
    $replacement = '';
    $Link = str_replace($pattern, $replacement, $Link);

	$patternYouTube = "www.";
    $replacementYouTube = '';
    $Link = str_replace($patternYouTube, $replacementYouTube, $Link);

	$patternYouTube = "youtube.com/";
    $replacementYouTube = '';
    $Link = str_replace($patternYouTube, $replacementYouTube, $Link);
	
	$Yqry = "INSERT INTO video SET DOG_ID ='" . $dogID . "', LINK = '" . $Link . "'";
	$Yresult=mysql_query($Yqry);
	
	$LOGqry = "INSERT INTO log SET
				USER_ID = '" . $_SESSION['SESS_MEMBER_ID'] . "',
				DOG_ID = '" . $dogID . "',
				ACTION = 'A5',
				COMMENT = ''";
	$LOGresult=mysql_query($LOGqry);
?>