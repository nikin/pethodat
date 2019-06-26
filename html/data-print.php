<?php
//Include database connection details
	require_once('auth.php');
	require_once('function.php');
	
	$dogID = $_GET['ID'];
			
// Adatbázis elérése
	$qry="SELECT * FROM dogs WHERE DOG_ID='".$dogID."'";
	$result=mysql_query($qry);
	if (mysql_num_rows($result) == 0 ){
		$qry="SELECT * FROM archive_dogs WHERE DOG_ID='".$dogID."'";
		$result=mysql_query($qry);
	}
	
	$dog = mysql_fetch_assoc($result);
	
	$STqry = "SELECT * FROM data WHERE ID LIKE 'ST%'";
	$STresult=mysql_query($STqry);
	$SEqry = "SELECT * FROM data WHERE ID LIKE 'SE%'";
	$SEresult=mysql_query($SEqry);
	$Hqry = "SELECT * FROM data WHERE ID LIKE 'H%'";
	$Hresult=mysql_query($Hqry);
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/DataPrint.css" rel="stylesheet" type="text/css" />
<title>Adatlap - <?php print $dog['DOG_NAME'] ?></title>
</head>

<body>
<script>print();</script>
<?php
//		---------------------------------------- ADATLAP ----------------------------------------

	print "
	<div id=\"DataPage\">
	<table id=\"adatlap\" width=\"1240\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				<tr height=\"33\">
    				<td rowspan=\"13\" class=\"center\" colspan=\"2\"><img id='upload' title='".$dog['DOG_NAME']."' src=\"pictures/".$dogID.".jpg\" height=\"400\"></td>
    				<td class=\"right\"><b>Azonosító:</b></td>
    				<td class=\"pl\">".$dogID."</td>
  				</tr>
  			<tr height=\"33\">
				<td class=\"right\"><b>Kutya neve:</b></td>
    			<td class=\"pl\">".$dog['DOG_NAME']."</td>
  			</tr>
  			<tr height=\"33\">
				<td class=\"right\"><b>Státusz:</b></td>
				<td class=\"pl\"><b>".DataName($dog['STATUS'])."<b></td>
  			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Fajta:</b></td>
				<td class=\"pl\">".$dog['BREED']."</td>
			</tr>
		  	<tr height=\"33\">
				<td class=\"right\"><b>Nem:</b></td>
				<td class=\"pl\">".DataName($dog['SEX'])."</td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Szőrzet:</b></td>
				<td class=\"pl\">".DataName($dog['HAIR'])."</td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Szinezet:</b></td>
				<td class=\"pl\">".$dog['COLOUR']."</td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>Születési idő:</b></td>
				<td class=\"pl\">".$dog['B_DATE']."&nbsp;&nbsp;<b>Becsült:</b>&nbsp;&nbsp;";
				if ($dog['ESTIMATED'] == '0'){
					print" <input type=\"checkbox\" disabled>";
				}
				else {
					print"<input type=\"checkbox\" checked disabled>";
				}
		print"</td>
		  </tr>
		  <tr height=\"33\">		
			<td class=\"right\"><b>Marmagasság:</b></td>
			<td class=\"pl\">".$dog['MARM']." cm</td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>Chip:</b></td>
				<td class=\"pl\">".$dog['CHIP']."</td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>Oltási könyv sz.:</b></td>
				<td class=\"pl\">".$dog['BOOK_NBR']."</td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>Befogás dátuma:</b></td>
				<td class=\"pl\">".$dog['BEF_DATE']."</td>
		  </tr>
		  <tr height=\"33\">				
				<td class=\"right\"><b>Befogás helye:</b></td>
				<td class=\"pl\">".$dog['BEF_PLACE']."</td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\" width=\"200\"><b>Befogás körülményei:</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea cols=\"120\" rows=\"5\" readonly=\"readonly\" resize=\"none\">".$dog['BEF_COND']."</textarea></td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\" width=\"200\"><b>Kutya jellemzése:</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea cols=\"120\" rows=\"10\" readonly=\"readonly\" resize=\"none\">".$dog['CHARACT']."</textarea></td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\" width=\"200\"><b>Megjegyzés:</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea name=\"comment\" readonly=\"readonly\" cols=\"120\" rows=\"2\" resize=\"none\">".$dog['COMMENT']."</textarea></td>
		  </tr>
		</table>
	</div>";

	//print "<div class='floatr'>".DogName($dogID)."</div>";
?>
</body>
</html>