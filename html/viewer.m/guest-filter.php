<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
	session_start();
	
	// CONNECT TO DATABASE
	require_once('config.php');
	require_once('../function.php');
	
	$Filter = (isset($_GET['FILTER'])) ? $_GET['FILTER'] : '';
	$Sex = $_GET['Sex'];
	$Hair = $_GET['Hair'];
	$Size = $_GET['Size'];
	$Lang = $_GET['Lang'];
	$IvD = $_GET['IvD'];
	$Stat = $_GET['Stat'];
	
	$user_agent = $_SERVER['HTTP_USER_AGENT']; 
	if (preg_match('/Firefox/i', $user_agent) || preg_match('/Chrome/i', $user_agent)) { 
  	}
	else {
   		$Filter = iconv("ISO-8859-2", "UTF-8",$Filter);
	} 
	
	if ($Size == 'SZ1'){ $marm = "AND MARM < '35'"; }
	elseif ($Size == 'SZ2'){ $marm = "AND MARM >= '35' AND MARM <= '50'"; }
	elseif ($Size == 'SZ3'){ $marm = "AND MARM > '50'";	}
	else { $marm = "";}
	
	$qry="SELECT * FROM dogs WHERE (DOG_NAME LIKE '%".$Filter."%' OR CHIP LIKE '%".$Filter."%' OR COLOUR LIKE '%".$Filter."%' OR B_DATE LIKE '%".$Filter."%' OR BEF_PLACE LIKE '%".$Filter."%' OR BEF_DATE LIKE '%".$Filter."%') AND SEX LIKE '%".$Sex."%' AND HAIR LIKE '%".$Hair."%' ".$marm." AND IV LIKE '%".$IvD."%' AND STATUS LIKE '%".$Stat."%' AND STATUS NOT IN ('ST4','ST5','ST0','ST6') ORDER BY BEF_DATE DESC";
	setcookie ("PetHoDat", $qry);

	$result=mysql_query($qry);
	$sorsz = mysql_num_rows($result);

print "
<div class=\"fejl center\">
</div>
	<div id=\"GuestResults\" class=\"bordered floatc\">
		<p>".DataName('G20',$Lang).": ".$sorsz." db</p>";
		$i=1;
			if ($sorsz > 0){
				while ($dogs = mysql_fetch_assoc($result)) {
					print "
					<div id=\"GuestDogForm\" class=\"bordered \" onMouseOver=\"this.className='highlight bordered'\" onMouseOut=\"this.className='bordered'\" onclick=\"javascript:Next('0','".$dogs['DOG_ID']."')\"\" >
						<div id=\"GuestDogPicture\" class=\"center\">
							<img src=\"../pictures/".$dogs['DOG_ID'].".jpg\" width=\"300px\" title=\"".$dogs['DOG_NAME']."\" border=\"0\">
						</div>
						<h1>".$dogs['DOG_NAME']."</h1>
						<p>".DataName($dogs['SEX'],$Lang)." - ".GetSize($dogs['MARM'],$Lang)." - ".DataName($dogs['HAIR'],$Lang)."</p>
						<p>".DataName($dogs['STATUS'],$Lang)."</p>
					</div>";
				}
			}
print "</div>";
?>
</html>