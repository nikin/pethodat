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
	
	$Vqry = "SELECT * FROM video WHERE DOG_ID='".$dogID."'";
	$Vresult = mysql_query($Vqry);
	//$Video = mysql_fetch_assoc($Vresult);
	//if($Video['LINK'] != ''){
	//	$YouTube = "http://www.youtube.com/".$Video['LINK'];
	//}
?>
<script type="text/javascript" src="js/ajaxupload.3.5.js" ></script>
<script type="text/javascript" >
	$(document).ready(function(){
            $("#bef_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#bdate").datepicker({
                dateFormat: 'yy-mm-dd'
            });
    	});
	
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: 'process/upload-file.php?dogID=<?php print $dogID;?>',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response!="error"){
					location.reload();
				} else{
					$('<p>Hiba lépett fel a feltöltés közben</p>').appendTo('#status');
				}
			}
		});
		
	});
	
	function ChangeStatus(stID){
		var ajaxRequest = new AjaxReq();
		AjaxDisp(ajaxRequest,'proba');		
		var dogID = '<?php print $dogID; ?>';
		var queryString = '?dogID=' + dogID + '&stID=' + stID;
			ajaxRequest.open('GET', 'process/changest.php'+ queryString, true);
			ajaxRequest.send();
	};
	
	function ChangeComment(Comm){
		var ajaxRequest = new AjaxReq();
		AjaxDisp(ajaxRequest,'proba');	
		var dogID = '<?php print $dogID; ?>';
		var queryString = '?Table=dogs&ID=' + dogID + '&COMMENT=' + Comm;
			ajaxRequest.open('GET', 'process/changecomment.php'+ queryString, true);
			ajaxRequest.send(null); 
	};
	
	function getSelectedButton(buttonGroup){
    	for (var i = 0; i < buttonGroup.length; i++) {
        	if (buttonGroup[i].checked) {
            	return i;
        	}
    	}
    	return 0;
	}
	
	function addVideo(dogID){
		if (document.Video.NewYouTube.value == ''){
			alert ('Hiányzó adat!');
		}
		else {
			var ajaxRequest = new AjaxReq();
			AjaxDisp(ajaxRequest,'YouTube');	
			var queryString = '?ID=' + dogID + '&Link=' + document.Video.NewYouTube.value;
			ajaxRequest.open('GET', 'process/addvideo.php'+ queryString, true);
			ajaxRequest.send(null); 
			alert('YouTube link sikeresen mentve!');
			window.location.reload();
		}
	}
	
	function delVideo(ID){
		var ajaxRequest = new AjaxReq();
		AjaxDisp(ajaxRequest,'YouTube');
		var queryString = '?ID=' + ID;
		ajaxRequest.open('GET', 'process/delvideo.php'+ queryString, true);
		ajaxRequest.send(null); 
		alert('YouTube link törölve!');
		window.location.reload();
	}
	
	function UpdateData(){
		if(document.DogUpdate.dog_name.value == ''){alert('A kutya neve hiányzik!');return false;}
		if(document.DogUpdate.colour.value == ''){alert('Add meg a kutya színét!');return false;}
		if(document.DogUpdate.bdate.value == ''){alert('Születési dátum???');return false;}
		if(document.DogUpdate.marm.value == ''){alert('Marmagasság?');return false;}
		if(document.DogUpdate.bef_date.value == ''){alert('Befogás ideje?');return false;}
		if(document.DogUpdate.bef_place.value == ''){alert('Befogás helye?');return false;}
		if(document.DogUpdate.bef_cond.value == ''){alert('Befogás körülményei?');return false;}
		if(document.DogUpdate.charact.value == ''){alert('Kutya jellemzése hiányzik');return false;}
		
		answer = confirm('Mented a módosításokat?');
		
		if (answer){ return true;}
		else { return false;}
	};
	
</script>
<div id="proba"></div>
<?php
	if ($dog['STATUS'] != 'ST5'){
	if ($_SESSION['RIGHTS'] == '1' or $_SESSION['RIGHTS'] == '2'){
			print "<div id='navi'>
		<ul>
			<li><a href=\"javascript:showAndHideTab('DogEdit','DogData')\"><img title='Kutya adatainak módosítása' src=\"images/edit.png\" width=\"48\" height=\"48\" border=\"0\"></a></li>
			<li><a href=\"data-print.php?ID=".$dogID."\" target=\"_new\"><img title='Adatlap nyomtatása' src=\"images/print.png\" width=\"48\" height=\"48\" border=\"0\"></a></li>
		</div>";
//		---------------------------------------- MÓDOSÍTÁS ----------------------------------------
		
		print "<div id=\"DogEdit\" style=\"display:none\">
		<form name=\"DogUpdate\" id=\"DogUpdate\" method=\"post\" action=\"process/updatedata.php\" onsubmit=\"return UpdateData()\">
		<table id=\"adatlap\" width=\"900\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					if (!file_exists("pictures/".$dogID.".jpg")) {
					print "
						<tr height=\"33\">
							<td colspan=\"2\" rowspan=\"7\" class=\"center\">
								<input id='upload2' type='button' value='Kép Feltöltése...' />
								<span id='status' ></span>
								</td>
							<td class=\"right\"><b>Azonosító:</b></td>
							<td class=\"pl textf\" colspan=\"2\"><input type=\"text\" name=\"dogID\" size=\"7\" maxlength=\"6\" value=\"".$dogID."\" readonly/></td>
						</tr>";
					}
					else {
				print"
				<tr height=\"33\">
    				<td colspan=\"2\" rowspan=\"7\" class=\"center\"><img title='".$dog['DOG_NAME']."' src=\"pictures/".$dogID.".jpg\" height=\"200\"></td>
    				<td class=\"right\"><b>Azonosító:</b></td>
					<td class=\"pl textf\" colspan=\"2\"><input type=\"text\" name=\"dogID\" size=\"7\" maxlength=\"6\" value=\"".$dogID."\" readonly/></td>
  				</tr>";
			}
			print"
  			<tr height=\"33\">
				<td class=\"right\"><b>Kutya neve:</b></td>
    			<td class=\"pl textf\" colspan=\"2\"><input type=\"text\" name=\"dog_name\" size=\"35\" maxlength=\"30\" value=\"".$dog['DOG_NAME']."\"/></td>
  			</tr>
			<tr height=\"33\">
				<td class=\"right\"></td>
				<td class=\"pl\" colspan=\"2\"></td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Fajta:</b></td>
				<td class=\"pl textf\" colspan=\"2\"><input type=\"text\" name=\"breed\" size=\"35\" maxlength=\"90\" value=\"".$dog['BREED']."\"/></td>
			</tr>
		  	<tr height=\"33\">
				<td class=\"right\"><b>Nem:</b></td>
				<td class=\"pl textf\" colspan=\"2\"><select name=\"sex\" id=\"sex\">";
				while ($StatusID = mysql_fetch_assoc($SEresult)) {
					if ($StatusID['ID'] == $dog['SEX']){
						print "<option value=".$StatusID['ID']." selected=\"selected\">".$StatusID['DATA_HU']."</option>";
					}
					else{
						print "<option value=".$StatusID['ID'].">".$StatusID['DATA_HU']."</option>";
					}
				}
				print"</select></td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Szőrzet:</b></td>
				<td class=\"pl textf\" colspan=\"2\"><select name=\"hair\" id=\"hair\">";
				while ($StatusID = mysql_fetch_assoc($Hresult)) {
					if ($StatusID['ID'] == $dog['HAIR']){
						print "<option value=".$StatusID['ID']." selected=\"selected\">".$StatusID['DATA_HU']."</option>";
					}
					else{
						print "<option value=".$StatusID['ID'].">".$StatusID['DATA_HU']."</option>";
					}
				}
				print"</select></td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Szinezet:</b></td>
				<td class=\"pl textf\" colspan=\"2\"><input type=\"text\" name=\"colour\" size=\"35\" maxlength=\"30\" value=\"".$dog['COLOUR']."\"/></td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>Születési idő:</b></td>
				<td class=\"pl textf\" width=\"250\"><input name=\"bdate\" type=\"text\" id=\"bdate\" size=\"10\" maxlength=\"10\" value=\"".$dog['B_DATE']."\"/>&nbsp;&nbsp;<b>Becsült:</b>&nbsp;&nbsp;";
				if ($dog['ESTIMATED'] == '0'){
					print"<input name=\"estimated\" type=\"checkbox\">";
				}
				else {
					print"<input name=\"estimated\" type=\"checkbox\" checked >";
				}
		print"</td>
				<td class=\"right\"><b>Marmagasság:</b></td>
				<td class=\"pl textf\"><input name=\"marm\" type=\"text\" size=\"3\" maxlength=\"3\" value=\"".$dog['MARM']."\"/> cm</td>
		  </tr>
		  <tr height=\"33\">
				<td width=\"190\" class=\"right\"><b>Chip:</b></td>
				<td width=\"170\" class=\"pl textf\"><input name=\"chip\" type=\"text\" size=\"35\" maxlength=\"30\" value=\"".$dog['CHIP']."\"/></td>
				<td width=\"130\"class=\"right\"><b>Oltási könyv sz.:</b></td>
				<td width=\"340\" class=\"pl textf\"><input type=\"text\" name=\"book_nbr\" size=\"25\" maxlength=\"20\" value=\"".$dog['BOOK_NBR']."\"/></td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>Befogás dátuma:</b></td>
				<td class=\"pl textf\"><input type=\"text\" name=\"bef_date\" id=\"bef_date\" size=\"10\" maxlength=\"10\" value=\"".$dog['BEF_DATE']."\"/></td>
				<td class=\"right\"><b>Befogás helye:</b></td>
				<td class=\"pl textf\"><input type=\"text\" name=\"bef_place\" size=\"35\" maxlength=\"30\" value=\"".$dog['BEF_PLACE']."\"/></td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\"><b>Befogás körülményei:</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea name=\"bef_cond\" cols=\"80\" rows=\"3\" resize=\"none\">".$dog['BEF_COND']."</textarea></td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\"><b>Kutya jellemzése:</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea name=\"charact\" cols=\"80\" rows=\"3\" resize=\"none\">".$dog['CHARACT']."</textarea></td>
		  </tr>
		  <tr height='25'>
				<td class=\"right\" valign=\"top\"><img src=\"images/photos.png\" height=\"50\" border=\"0\" title=\"Képek\"/></td>
				<td class=\"pl textf\" colspan=\"3\">";
				if ($dog['WEB'] == 'AUTO'){
      				print "<input type='radio' name='LinkGroup' value='AUTO' checked='checked'>Automatikus<br />
    						<input type='radio' name='LinkGroup' value='Link'/>http://<input name='Link' type='text' size='75' maxlength='100'/>";
				}
				else { print "<input type='radio' name='LinkGroup' value='AUTO'>Automatikus<br />
						<input type='radio' name='LinkGroup' value='Link' checked='checked'/>http://<input name='Link' type='text' size='75' maxlength='100' value='".$dog['WEB']."' />";}
    print"
    
      </td>
		  <tr height='30'>
				<td class=\"right\" valign=\"top\"></td>
				<td class=\"right\" colspan=\"3\"><input class=\"ok\" name=\"Save\" type=\"submit\" value=\"\" title=\"Mentés\" />
							<input class='cancel' title=\"Mégsem\" name=\"Chancel\" type=\"button\" onclick=\"javascript:showAndHideTab('DogData','DogEdit')\"/></td>
		  </tr> 
		</table>
		</form>
		<div id='YouTube'></div>
		</div>";
		}
	}
		else{}
//		---------------------------------------- MODOSÍTÁS VÉGE ----------------------------------------


//		---------------------------------------- ADATLAP ----------------------------------------

	print "<div id=\"DogData\">
	<table id=\"adatlap\" width=\"900\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					if (!file_exists("pictures/".$dogID.".jpg")) {
					print "
						<tr height=\"33\">
							<td colspan=\"2\" rowspan=\"7\" class=\"center\">
								<input id='upload' type='button' value='Kép Feltöltése...' />
								<span id='status' ></span>
								</td>
							<td class=\"right\"><b>Azonosító:</b></td>
							<td class=\"pl\" colspan=\"2\">".$dogID."</td>
						</tr>";
					}
					else {
				print"
				<tr height=\"33\">
    				<td colspan=\"2\" rowspan=\"7\" class=\"center\"><img id='upload' title='".$dog['DOG_NAME']."' src=\"pictures/".$dogID.".jpg\" height=\"200\"></td>
    				<td class=\"right\"><b>Azonosító:</b></td>
    				<td class=\"pl\" colspan=\"2\">".$dogID."</td>
  				</tr>";
			}
			print"
  			<tr height=\"33\">
				<td class=\"right\"><b>Kutya neve:</b></td>
    			<td class=\"pl\" colspan=\"2\">".$dog['DOG_NAME']."</td>
  			</tr>
  			<tr height=\"33\">
				<td class=\"right\"><b>Státusz:</b></td>";
				if ($dog['STATUS'] == 'ST4'){
					print "<td class=\"pl\" colspan=\"2\"><b>GAZDÁS<b></td>";
				}
				elseif ($dog['STATUS'] == 'ST5'){
					print "<td class=\"pl\" colspan=\"2\"><b>ELPUSZTULT<b></td>";
				}
				else{
    				print "<td class=\"pl textf\" colspan=\"2\"><select name=\"status\" id=\"status\" onchange=\"javascript:ChangeStatus(this.value)\">";
				while ($StatusID = mysql_fetch_assoc($STresult)) {
					if ($StatusID['ID'] != 'ST4'){
						if ($StatusID['ID'] == $dog['STATUS']){
							print "<option value=".$StatusID['ID']." selected=\"selected\">".$StatusID['DATA_HU']."</option>";
						}
						else{
							print "<option value=".$StatusID['ID'].">".$StatusID['DATA_HU']."</option>";
						}
					}
					else{}
				}
				print"</select></td>";
				}
			print"
  			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Fajta:</b></td>
				<td class=\"pl\" colspan=\"2\">".$dog['BREED']."</td>
			</tr>
		  	<tr height=\"33\">
				<td class=\"right\"><b>Nem:</b></td>
				<td class=\"pl\" colspan=\"2\">".DataName($dog['SEX'])."</td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Szőrzet:</b></td>
				<td class=\"pl\" colspan=\"2\">".DataName($dog['HAIR'])."</td>
			</tr>
			<tr height=\"33\">
				<td class=\"right\"><b>Szinezet:</b></td>
				<td class=\"pl\" colspan=\"2\">".$dog['COLOUR']."</td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>Születési idő:</b></td>
				<td class=\"pl\" width=\"250\">".$dog['B_DATE']."&nbsp;&nbsp;<b>Becsült:</b>&nbsp;&nbsp;";
				if ($dog['ESTIMATED'] == '0'){
					print" <input type=\"checkbox\" disabled>";
				}
				else {
					print"<input type=\"checkbox\" checked disabled>";
				}
		print"</td>
			<td class=\"right\"><b>Marmagasság:</b></td>
			<td class=\"pl\">".$dog['MARM']." cm</td>
		  </tr>
		  <tr height=\"33\">
				<td width=\"190\" class=\"right\"><b>Chip:</b></td>
				<td width=\"170\" class=\"pl\">".$dog['CHIP']."</td>
				<td width=\"130\"class=\"right\"><b>Oltási könyv sz.:</b></td>
				<td width=\"340\" class=\"pl\">".$dog['BOOK_NBR']."</td>
		  </tr>
		  <tr height=\"33\">
				<td class=\"right\"><b>Befogás dátuma:</b></td>
				<td class=\"pl\">".$dog['BEF_DATE']."</td>
				<td class=\"right\"><b>Befogás helye:</b></td>
				<td class=\"pl\">".$dog['BEF_PLACE']."</td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\"><b>Befogás körülményei:</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea cols=\"80\" rows=\"3\" readonly=\"readonly\" resize=\"none\">".$dog['BEF_COND']."</textarea></td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\"><b>Kutya jellemzése:</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea cols=\"80\" rows=\"3\" readonly=\"readonly\" resize=\"none\">".$dog['CHARACT']."</textarea></td>
		  </tr>
		  <tr>
				<td class=\"right\" valign=\"top\"><b>Megjegyzés:</b></td>
				<td class=\"pl textf\" colspan=\"3\"><textarea name=\"comment\" cols=\"80\" rows=\"3\" resize=\"none\" onkeyup=\"javascript:ChangeComment(this.value)\">".$dog['COMMENT']."</textarea></td>
		  </tr>
		  <tr height=\"30\">
				<td class=\"right\"><b>Ivartalanítás dátuma:</b></td>
				<td class=\"pl\" colspan=\"3\">";
				if($dog['IV_DATE'] == '0000-00-00'){
					print "";
				}
				else{
					print $dog['IV_DATE'];
				}
				print"</td>
		  </tr>
			<tr height='25'>
				<td class=\"right\" valign=\"top\"></td>
				<td class=\"pl textf\" colspan=\"3\">";
				if ($dog['WEB'] == 'AUTO'){
					print "<a href='http://gallery.site.hu/u/Ngabi/Siofoki-kutyusok/palbum158/".$dogID."/' target=\"_blank\"><img src=\"images/photos.png\" height=\"50\" border=\"0\" title=\"Képek\"/></a>";
				}
				else {print "<a href='http://".$dog['WEB']."' target=\"_blank\"><img src=\"images/photos.png\" height=\"50\" border=\"0\" title=\"Képek\"/></a>";}
		
		  if(isset($YouTube)){
			  print"<a class=\"NewLink\" href='".$YouTube."' target=\"_blank\"><img src=\"images/youtube.jpg\" height=\"50\" border=\"0\" title=\"YouTube\"/></a>";
		  }
		  print"</td>
		  </tr>
		  </tr>
		  <tr height='25'>
				<td class=\"right\" valign=\"top\"><a href='YouTube.php?ID=".$dogID."' target=\"_blank\"><img src=\"images/youtube.jpg\" height=\"50\" border=\"0\" title=\"YouTube\"/></a></td>
				<td class=\"pl textf\" colspan=\"3\" id=\"Youtube\">";
				while  ($Video = mysql_fetch_assoc($Vresult)) {
					print "http://youtube.com/".$Video['LINK']."  <input class='cancel_l' title=\"Törlés\" name=\"Del\" type=\"button\" onclick=\"javascript:delVideo('".$Video['ID']."')\"/><br>";
				}
				print"</td>
			</tr>
			<tr height='25'>
				<td class=\"right\" valign=\"top\"></td>
				<td class=\"pl textf\" colspan=\"3\">";
				if ($dog['STATUS'] != 'ST5'){
				print"<form name=\"Video\">http://youtube.com/<input name='NewYouTube' type='text' size='50' maxlength='100'/><input class='ok_l' title=\"Add\" name=\"Add\" type=\"button\" onclick=\"javascript:addVideo(".$dogID.")\"/></form>";
				}
				print"</td>
			</tr>
		</table>
	</div>";
	//print "<div class='floatr'>".DogName($dogID)."</div>";
?>