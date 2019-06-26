<?php
//Include database connection details
	require_once('auth.php');
	require_once('function.php');
	
	$dogID = $_GET['ID'];
?>

<script type="text/javascript">
       $(document).ready(function(){
           $("#mDate").datepicker({
               dateFormat: 'yy-mm-dd'
           });
 		});
		
		function SaveMed(){
			if(document.MedRegister.mDate.value == ''){alert('Dátum hiányzik!');return false;}
			if(document.MedRegister.mDesc.value == ''){alert('Leírás hiányzik');return false;}
			if(document.MedRegister.Doctor.value == ''){alert('Orvos neve???');return false;}
			
			answer = confirm('Rögzíted a kezelést?');
			if (answer) {
				
				var ajaxRequest = new AjaxReq();
				AjaxDisp(ajaxRequest,'Medicals');
				
				var dogID = '<?php print "".$dogID; ?>';
				var mDate = document.getElementById('mDate').value;
				var mType = document.getElementById('mType').value;
				var mDesc = document.getElementById('mDesc').value;
				var Doctor = document.getElementById('Doctor').value;
				var queryString = '?dogID=' + dogID + '&mDate=' + mDate + '&mType=' + mType + '&mDesc=' + mDesc + '&Doctor=' + Doctor;
				ajaxRequest.open('GET', 'process/newmed.php'+ queryString, true);
				ajaxRequest.send(null); 
				
				document.getElementById('NewMedical').style.display="none";
			};
			document.MedRegister.mDate.value = '';
				document.MedRegister.mDesc.value = '';
				document.MedRegister.Doctor.value = '';
		};
</script>

<?php
	// Adatbázis elérése
		$qry="SELECT * FROM dogs WHERE DOG_ID='".$dogID."'";
		$result=mysql_query($qry);
		if (mysql_num_rows($result) == 0 ){
			$qry="SELECT * FROM archive_dogs WHERE DOG_ID='".$dogID."'";
			$result=mysql_query($qry);
		}
		$dog = mysql_fetch_assoc($result);
		
		if ($dog['STATUS'] != 'ST5' && $dog['STATUS'] != 'ST4'){
			print "<div id='navi'>
					<ul>
						<li><a href=\"javascript:showTab('NewMedical')\"><img title='Kezelés Rögzítése' src=\"images/newmed.png\" width=\"48\" height=\"48\" border=\"0\"></a></li>			
					</ul>
				</div>";
		}
		print "
	<div id='NewMedical' style='display:none'>
			<form name='MedRegister' id='MedRegister' method='post' >
			<table width=\"550\" class='loginbox border'>
				<tr>
					<td class=\"right\">Dátum:</td>
					<td><input name=\"mDate\" type=\"text\" class=\"textfield\" id=\"mDate\" size=\"10\" maxlength=\"10\" /></td>
					<td class=\"right\">Kezelés:</td>
					<td width=\"50\" class=\"right\"><select class=\"textfield\" name=\"mType\" id=\"mType\">
            			<option value=\"M0\">".DataName(M0)."</option>";
						if ($dog['IV_DATE'] == '0000-00-00'){
	            			print"<option value=\"M1\">".DataName(M1)."</option>";
						}
						print"	
            			<option value=\"M2\">".DataName(M2)."</option>
						<option value=\"M3\">".DataName(M3)."</option>
            			</select>
					</td>
				</tr>
				<tr>
					<td class=\"right\">Leírás:</td>
					<td colspan=\"3\"><textarea cols=\"50\" rows=\"5\" name=\"mDesc\" type=\"text\" class=\"textfield\" id=\"mDesc\"/></textarea></td>
				</tr>
				<tr>
					<td class=\"right\">Kezelő Orvos:</td>
					<td colspan=\"3\"><input name=\"Doctor\" type=\"text\" class=\"textfield\" id=\"Doctor\" size=\"30\" maxlength=\"25\" /></td>
				</tr>
					<td colspan=\"3\" class=\"right\">
						<input class='ok' title='Rögzít' type=\"button\" onclick=\"javascript:SaveMed();\" />
						<input class='cancel' title='Mégsem' type=\"button\" onclick=\"javascript:hideTab('NewMedical')\"/>
					</td>
				</tr>
			</table>
			</form>
	</div>";
				
	$Mqry="SELECT * FROM medical WHERE DOG_ID='".$dogID."'";
		$Mresult=mysql_query($Mqry);
		if (mysql_num_rows($Mresult) == 0 ){
			$Mqry="SELECT * FROM archive_medical WHERE DOG_ID='".$dogID."'";
			$Mresult=mysql_query($Mqry);
		}
	
	print "<div id=\"Medicals\">";
	if(mysql_num_rows($Mresult) == 0) { // Ha nem találja a DOG_ID-t akkor NINCS orvosi adat
		print "<h3>Nincsenek Orvosi Adatok</h3>";
	}
	else {
		print "<table class='loginbox border center' cellpadding='0' cellspacing='0' border='0' width='600'>
						<thead>
							<tr height='35'>
								<th width='100'>Dátum</th>
								<th width='100'>Kezelés</th>
								<th width='200'>Leírás</th>
								<th width='150'>Orvos</th>
							</tr>
						</thead>";
		$i=1;
		while ($medic = mysql_fetch_assoc($Mresult)) {
			if($i % 2 == 0){
				print "<tr height='25 class=\"sor1\"'>
							<td>".$medic['DATE']."</td>
							<td>".DataName($medic['TYPE'])."</td>
							<td class=\"justify\">".$medic['M_DESC']."</td>
							<td>".$medic['DOCTOR']."<td>
						</tr>";
			}
			else {
				print "<tr height='25' class=\"sor2\">
							<td>".$medic['DATE']."</td>
							<td>".DataName($medic['TYPE'])."</td>
							<td class=\"justify\">".$medic['M_DESC']."</td>
							<td>".$medic['DOCTOR']."<td>
						</tr>";
			}
			$i++;
		}
		print "<tr height='10'></tr>
			</table>";
	}
	
	print "</div>";
	
	//print "<div class='floatr'>".DogName($dogID)."</div>";
?>