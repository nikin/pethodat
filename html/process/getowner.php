<script>
function ChangeComment(OwnerID,Comm){
		var ajaxRequest;  // The variable that makes Ajax possible!
	
				try{
					// Opera 8.0+, Firefox, Safari
					ajaxRequest = new XMLHttpRequest();
				} catch (e){
					// Internet Explorer Browsers
					try{
						ajaxRequest = new ActiveXObject('Msxml2.XMLHTTP');
					} catch (e) {
						try{
							ajaxRequest = new ActiveXObject('Microsoft.XMLHTTP');
						} catch (e){
							// Something went wrong
							alert('Your browser broke!');
							return false;
						}
					}
				}
	
				// Create a function that will receive data sent from the server
				ajaxRequest.onreadystatechange = function(){
						if(ajaxRequest.readyState == 4){
						var ajaxDisplay = document.getElementById('proba');
						ajaxDisplay.innerHTML = ajaxRequest.responseText;
				}
			}
		var queryString = '?Table=owner&ID=' + OwnerID + '&COMMENT=' + Comm;
			ajaxRequest.open('GET', 'process/changecomment.php'+ queryString, true);
			ajaxRequest.send(null); 
	};
</script>
<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');

	$ownerID=$_GET["ownerID"];

	$Oqry="SELECT * FROM owner WHERE OWNER_ID = '".$ownerID."'";
	$Oresult=mysql_query($Oqry);
	$Owner = mysql_fetch_assoc($Oresult);
	
	print" <table>
			<tr>
					<td class=\"right\"><b>E-mail:</b></td>
					<td width=\"50\" class=\"right\">".$Owner['EMAIL']."</td>
					<td class=\"right\"><b>Telefon:</b></td>
					<td colspan=\"3\">".$Owner['TEL']."</td>
				</tr>
				<tr>
					<td class=\"right\"><b>Irányítószám:</b></td>
					<td width=\"50\">".$Owner['P_CODE']."</td>
					<td class=\"right\"><b>Város:</b></td>
					<td colspan=\"3\">".$Owner['CITY']."</td>
				</tr>
				<tr>
					<td class=\"right\"><b>Cím:</b></td>
					<td width=\"50\" colspan=\"3\">".$Owner['ADDRESS']."</td>
				</tr>
				<tr>
					<td class=\"right\"><b>Megjegyzés:</b></td>
					<td class=\"pl textf\" colspan=\"3\"><textarea cols=\"50\" rows=\"3\" onchange=\"javascript:ChangeComment(".$Owner['OWNER_ID'].",this.value)\" resize=\"none\">".$Owner['COMMENT']."</textarea></td>
				</tr>
			</table>";
?>