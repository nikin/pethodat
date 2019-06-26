<?php
	session_start();
	
	// CONNECT TO DATABASE
	require_once('config.php');
	require_once('../function.php');
	
	//$qry="SELECT * FROM dogs WHERE STATUS NOT IN ('ST4','ST5')";
	if (!isset($_SESSION['qry'])){
		$qry=$_COOKIE["PetHoDat"];
	}
	else {
		$qry=$_SESSION['qry'];
	}
	
	$result=mysql_query($_COOKIE["PetHoDat"]);
	$sorsz = mysql_num_rows($result);
	$dogID = $_GET['dogID'];
	$Lang = $_GET['Lang'];
	
	for ($i=1; $i <= $sorsz; $i++) {
		$dog[$i] = mysql_fetch_assoc($result);
		if (isset($dogID)){
			if ($dog[$i]['DOG_ID'] == $dogID){
				$y = $i;
			}
		}
	}
	
	if (isset($y)) {$i = $y;}
	else {$i = $_GET['ID'];}
	
	if ($i == 1) { $y = $sorsz;}
	else { $y = $i-1;}
	if ($i == $sorsz) { $x = 1;}
	else {$x = $i+1;}
	
	print "
<div id=\"Kep\" class=\"floatl border mh8\" style=\"display:none\">
		<a href=\"javascript:popup('Kep')\"><img title='Bezár' src=\"../pictures/".$dog[$i]['DOG_ID'].".jpg\" border=\'0\"></a>
	</div>
	<div class=\"fejl center\">
		<table width=\"1000px\" class=\"floatc\">
			<tr>
				<td width=\"70\"><a href=\"javascript:Next('$y')\"><img src=\"../images/prew.png\" width=\"48\" height=\"48\" title=\"Előző\" border=\'0\"></a></td>
				<td><h1>".DataName('G19',$Lang)."</h1>
				<p>".DataName('G20',$Lang).": ".$sorsz." db</p></td>
				<td width=\"70\"><a href=\"javascript:Next('$x')\"><img src=\"../images/next.png\" width=\"48\" height=\"48\" title=\"Következő\" border=\'0\"></a></td>
			</tr>
		</table>
	</div>
		<div>
		<table class=\"border floatc\" id=\"adatlap\"  width=\"1000px\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		";
				if (!file_exists("../pictures/".$dog[$i]['DOG_ID'].".jpg")) {
					print "
						<tr height=\"33\">
							<td colspan=\"2\" rowspan=\"7\" class=\"center\">".DataName('G21',$Lang)."</td>
							<td class=\"right\"><b>".DataName('G10',$Lang).":</b></td>
							<td class=\"pl\" colspan=\"2\">".$dog[$i]['DOG_ID']."</td>
						</tr>";
					}
					else {
				print"
				<tr height=\"33\">
    				<td colspan=\"2\" rowspan=\"7\" class=\"center\"><a href=\"javascript:popup('Kep')\"><img title='Megnyit' src=\"../pictures/".$dog[$i]['DOG_ID'].".jpg\" height=\"200\" border=\'0\"></a></td>
    				<td class=\"right\"><b>".DataName('G10',$Lang).":</b></td>
    				<td class=\"pl\" colspan=\"2\">".$dog[$i]['DOG_ID']."</td>
  				</tr>";
			}
			print"
  			<tr height=\"33\">
				<td class=\"right\"><b>".DataName('G04',$Lang).":</b></td>
    			<td class=\"pl\" colspan=\"2\">".$dog[$i]['DOG_NAME']."</td>
  			</tr>
  			<tr height=\"33\">
				<td class=\"right\"><b>".DataName('G11',$Lang).":</b></td>
				<td class=\"pl\" colspan=\"2\">".dataname($dog[$i]['STATUS'],$Lang)."</td>
  			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>".DataName('G18',$Lang).":</b></td>
				<td class=\"pl\" colspan=\"2\">".$dog[$i]['BREED']."</td>
			</tr>
		  	<tr height=\"33\">
				<td class=\"right\"><b>".DataName('G02',$Lang).":</b></td>
				<td class=\"pl\" colspan=\"2\">".DataName($dog[$i]['SEX'],$Lang)."</td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>".DataName('G03',$Lang).":</b></td>
				<td class=\"pl\" colspan=\"2\">".DataName($dog[$i]['HAIR'],$Lang)."</td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>".DataName('G05',$Lang).":</b></td>
				<td class=\"pl\" colspan=\"2\">".$dog[$i]['COLOUR']."</td>
		  </tr>
		  <tr height=\"33\">
				<td width=\"150\"class=\"right\"><b>".DataName('G06',$Lang).":</b></td>
				<td class=\"pl\" width=\"250\">".$dog[$i]['B_DATE']."&nbsp;&nbsp;<b>".DataName('G12',$Lang).":</b>&nbsp;&nbsp;";
				if ($dog['ESTIMATED'] == '0'){
					print" <input type=\"checkbox\" disabled>";
				}
				else {
					print"<input type=\"checkbox\" checked disabled>";
				}
		print"</td>
			<td width=\"130\" class=\"right\"><b>".DataName('G13',$Lang).":</b></td>
			<td width=\"340\" class=\"pl\">".$dog[$i]['MARM']." cm</td>
		  </tr>
		  <tr height=\"33\">
				<td width=\"190\" class=\"right\"><b>".DataName('G09',$Lang).":</b></td>
				<td width=\"170\" class=\"pl\">".$dog[$i]['CHIP']."</td>
				<td width=\"130\"class=\"right\"></td>
				<td width=\"340\" class=\"pl\"></td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>".DataName('G08',$Lang).":</b></td>
				<td class=\"pl\">".$dog[$i]['BEF_DATE']."</td>
				<td class=\"right\"><b>".DataName('G07',$Lang).":</b></td>
				<td class=\"pl\">".$dog[$i]['BEF_PLACE']."</td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\"><b>".DataName('G14',$Lang).":</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea cols=\"80\" rows=\"5\" readonly=\"readonly\" resize=\"none\">".$dog[$i]['BEF_COND']."</textarea></td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\"><b>".DataName('G15',$Lang).":</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea cols=\"80\" rows=\"5\" readonly=\"readonly\" resize=\"none\">".$dog[$i]['CHARACT']."</textarea></td>
		  </tr>
		  <tr height=\"30\">
				<td class=\"right\"><b>".DataName('G16',$Lang).":</b></td>
				<td class=\"pl\" colspan=\"3\">";
				if($dog['IV_DATE'] == '0000-00-00'){
					print "";
				}
				else{
					print $dog['IV_DATE'];
				}
				print"</td>
		  </tr>
			<tr height='30'>
				<td class=\"right\" valign=\"top\"></td>
				<td class=\"pl textf\" colspan=\"3\" valign=\"top\">";
				if ($dog[$i]['WEB'] == 'AUTO'){
					print "<a href='http://gallery.site.hu/u/Ngabi/Siofoki-kutyusok/palbum158/".$dog[$i]['DOG_ID']."/' target=\"_blank\"><img src=\"../images/photos.png\" height=\"50\" border=\"0\" title=\"".DataName('G17',$Lang)."\"/></a>";
				}
				else {print "<a href='http://".$dog[$i]['WEB']."' target=\"_blank\"><img src=\"../images/photos.png\" height=\"50\" border=\"0\" title=\"".DataName('G17',$Lang)."\"/></a>";}
				
		  		$Vqry = "SELECT LINK FROM video WHERE DOG_ID='".$dog[$i]['DOG_ID']."'";
				$Vresult = mysql_query($Vqry);
				if (mysql_num_rows($Vresult) > 0) {
					print"<a href='../YouTube.php?ID=".$dog[$i]['DOG_ID']."' target=\"_blank\"><img src=\"../images/youtube.jpg\" height=\"50\" border=\"0\" title=\"YouTube\"/></a>";}
				
		  print"
		  </td>
		  </tr>
		</table>
		</div></div>";
?>