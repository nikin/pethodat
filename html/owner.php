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
?>

<script type="text/javascript">
		var dogID = <?php print $dogID;?>
		
		function ShowOwner(ownerID){
			var ajaxRequest = new AjaxReq();
			AjaxDisp(ajaxRequest,'OwnerData');
				
			ajaxRequest.open('GET', 'process/getowner.php?ownerID=' + ownerID, true);
			ajaxRequest.send(null); 
			}
						
		function DelOwner(){
				var answer = confirm('Biztos törlöd az örökbefogadót?');
				if (answer){
					alert('A kutya ÚJ státusza VISSZAKERÜLT!!');
					
					var ajaxRequest = new AjaxReq();
					AjaxDisp(ajaxRequest,'Owners');
					
					ajaxRequest.open('GET', 'process/delowner.php?dogID=' + dogID, true);
					ajaxRequest.send(null); 
					
				}
				ajaxRequest.onreadystatechange=function()
  					{
			  		if (ajaxRequest.readyState==4 && ajaxRequest.status==200)
    					{window.location = 'http://siofokiallatvedo.hu/pethodat/member-index.php?oldal=adatlap&ID=' + dogID;}
					}
				 				
		}
		
		function ChangeComment(OwnerID,Comm){
			var ajaxRequest = new AjaxReq();
			AjaxDisp(ajaxRequest,'proba');	
				
		var queryString = '?Table=owner&ID=' + OwnerID + '&COMMENT=' + Comm;
			ajaxRequest.open('GET', 'process/changecomment.php'+ queryString, true);
			ajaxRequest.send(null); 
	};
</script>

<?php
	print "<div id=\"Owners\">";
	$dog = mysql_fetch_assoc($result);
		
	if($dog['OWNER_ID'] != 0){
		$Oqry="SELECT * FROM owner WHERE OWNER_ID = '".$dog['OWNER_ID']."'";
		$Oresult=mysql_query($Oqry);
		$owner = mysql_fetch_assoc($Oresult);
		
		if ($_SESSION['RIGHTS'] != '0' && $dog['STATUS'] != 'ST5'){
			print "<div id='navi'>
		<ul>
			<li><a href=\"print.php?ownerID=".$dog['OWNER_ID']."&dogID=".$dogID."\" target=\"_new\"><img title='Nyomtatás' src=\"images/print.png\" width=\"48\" height=\"48\" border=\"0\"></a></li>
			<li><a href=\"javascript:DelOwner()\"><img title='Örökbefogadó leválasztása' src=\"images/deluser.png\" width=\"48\" height=\"48\" border=\"0\"></a></li>
		</ul>
		</div>";
		}
		else{
			print "<div id='navi'>
		<ul>
			<li><a href=\"print.php?ownerID=".$dog['OWNER_ID']."&dogID=".$dogID."\"><img title='Nyomtatás' src=\"images/edituser.png\" width=\"48\" height=\"48\"></a></li>
		</div>";}
		
		print "<div id='OwnerBox'>
			<table id=\"adatlap\" width=\"600\" class='loginbox border'>
				<tr>
					<td class=\"right\"><b>Név:</b></td>
					<td colspan=\"3\">".$owner['NAME']."</td>
				</tr>
				<tr>
					<td class=\"right\"><b>E-mail:</b></td>
					<td width=\"220\">".$owner['EMAIL']."</td>
					<td width=\"50\" class=\"right\"><b>Telefon:</b></td>
					<td colspan=\"2\">".$owner['TEL']."</td>
				</tr>
				<tr>
					<td class=\"right\"><b>Irányítószám:</b></td>
					<td width=\"220\">".$owner['P_CODE']."</td>
					<td width=\"50\" class=\"right\"><b>Város:</b></td>
					<td colspan=\"2\">".$owner['CITY']."</td>
				</tr>
				<tr>
					<td class=\"right\"><b>Cím:</b></td>
					<td colspan=\"3\">".$owner['ADDRESS']."</td>
				</tr>
				<tr>
					<td class=\"right\"><b>Megjegyzés:</b></td>
					<td class=\"pl textf\" colspan=\"3\"><textarea cols=\"50\" rows=\"3\" onkeyup=\"javascript:ChangeComment(".$owner['OWNER_ID'].",this.value)\" resize=\"none\">".$owner['COMMENT']."</textarea></td>
				</tr>
			</table>
		</div>";
	}
	else {
		if ($dog['STATUS'] != 'ST5'){
			$OWqry="SELECT * FROM owner ORDER BY NAME";
			$OWresult=mysql_query($OWqry);
			print"<div id=\"OwnerID\">
				<form action='process/setowner.php' method='post' name='SetForm' id='SetForm'>
		<table id=\"adatlap\" width=\"600\" class='loginbox border'>
				<tr>
					<td width=\"80\" class=\"right\"><b>Név:</b></td>
					<td id=\"OwnerList\" width=\"150\" class=\"pl textf\"><select name=\"Owners\" id=\"Owners\" size=\"3\" onchange=\"javascript:ShowOwner(this.value)\">";
						while ($Owners = mysql_fetch_assoc($OWresult)) {
							print "<option value=\"".$Owners['OWNER_ID']."\">".$Owners['NAME']."</option>";
						}
					print"</select></td>
					<td class=\"left\" colspan=\"2\"><input type=\"hidden\" name=\"dogID\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"".$dogID."\" /></td>
				</tr>
				<tr>
				<td colspan=\"4\" id=\"OwnerData\"></td>
				</tr>
				<tr>
					<td colspan=\"4\" class=\"right\">
						<label><input type='submit' name='SetOwner' class='ok' value='' title='Mentés' /> </label>
						<input class='cancel' title=\"Mégsem\" name=\"Chancel\" type=\"button\" onclick=\"javascript:hideTab('SetOwner')\"/>
					</td>
				</tr>
		</table>
		</form>
				
		</div>";
		}
		else {print "<H3>NEM fogadták Örökbe</H3></div>";}
	}	
	print "<div>";
	
	//print "<div class='floatr'>".DogName($dogID)."</div>";
?>