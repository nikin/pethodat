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
	
	$Filter = $_GET['FILTER'];
	$Sex = $_GET['Sex'];
	$Hair = $_GET['Hair'];
	$Size = $_GET['Size'];
	$Lang = $_GET['Lang'];
	$IvD = $_GET['IvD'];
	$Stat = $_GET['Stat'];
	print "<br><br>";
	
	$user_agent = $_SERVER['HTTP_USER_AGENT']; 

if (preg_match('/Firefox/i', $user_agent) || preg_match('/Chrome/i', $user_agent)) { 
   echo "Firefox v Chrome";
} else {
   $Filter = iconv("ISO-8859-2", "UTF-8",$Filter);
} 
	
	print $Filter;
	if ($Size == 'SZ1'){ $marm = "AND MARM < '35'"; }
	elseif ($Size == 'SZ2'){ $marm = "AND MARM >= '35' AND MARM <= '50'"; }
	elseif ($Size == 'SZ3'){ $marm = "AND MARM > '50'";	}
	else { $marm = "";}
	
	$qry="SELECT * FROM dogs WHERE (DOG_NAME LIKE '%".$Filter."%' OR CHIP LIKE '%".$Filter."%' OR COLOUR LIKE '%".$Filter."%' OR B_DATE LIKE '%".$Filter."%' OR BEF_PLACE LIKE '%".$Filter."%' OR BEF_DATE LIKE '%".$Filter."%') AND SEX LIKE '%".$Sex."%' AND HAIR LIKE '%".$Hair."%' ".$marm." AND IV LIKE '%".$IvD."%' AND STATUS LIKE '%".$Stat."%' AND STATUS NOT IN ('ST4','ST5','ST0','ST6') ORDER BY BEF_DATE DESC";
	setcookie ("PetHoDat", $qry);

	$result=mysql_query($qry);
	$sorsz = mysql_num_rows($result);

print "
<div class=\"fejl44 center\">
	<table width=\"1200px\" cellpadding='0' cellspacing='0' class=\"floatc\">
		<tr>
			<td width=\"70\"></td>
			<td width=\"1060\"><h1>".DataName('G19',$Lang)."</h1></td>
			<td width=\"70\"></td>
		</tr>
	</table>
</div>
	<div>
		<table class=\"border floatc\" cellpadding='0' cellspacing='0' border='0' id='List' width='1200px'>
			<thead>
				<tr height='35' class=\"center\">
					<th>".DataName('G04',$Lang)."</th>
					<th width='80'>".DataName('G02',$Lang)."</th>
					<th>".DataName('SZ0',$Lang)."</th>
					<th>".DataName('G03',$Lang)."</th>
					<th>".DataName('G05',$Lang)."</th>
					<th>".DataName('G06',$Lang)."</th>
					<th>".DataName('G07',$Lang)."</th>
					<th>".DataName('G08',$Lang)."</th>
				</tr>
			</thead>
			<tbody align='center'>";
			$i=1;
			if ($sorsz > 0){
				while ($dogs = mysql_fetch_assoc($result)) {
					print "<tr id=\"$i\" height='30' class='tb' onclick=\"javascript:Next('$x','".$dogs['DOG_ID']."')\" onMouseOver=\"this.className='highlight'; showIt(".$dogs['DOG_ID'].",event);\" onMouseOut=\"ClosePopup('ind'); this.className='normal'\">
						<td class='left tb'>".$dogs['DOG_NAME']."</td>
						<td class='tb'>".DataName($dogs['SEX'],$Lang)."</td>
						<td class='tb'>".GetSize($dogs['MARM'],$Lang)."</td>
						<td class='tb'>".DataName($dogs['HAIR'],$Lang)."</td>
						<td class='tb'>".$dogs['COLOUR']."</td>
						<td class='tb'>".$dogs['B_DATE']."</td>
						<td class='tb'>".$dogs['BEF_PLACE']."</td>
						<td class='tb'>".$dogs['BEF_DATE']."</td>
						</tr>";
						$i++;
				}
			}
			else{
				print "<tr height='35' class='tb'>
						<td colspan=\"8\" class='left tb'>".DataName('G23',$Lang)."</td>";
			}
print "</tbody></table>
	</div>
";
?>
</html>