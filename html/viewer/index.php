<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 
if (preg_match('/Phone/i', $user_agent) || preg_match('/Android/i', $user_agent)) { 
	Header( "HTTP/1.1 301 Moved Permanently" ); /* véglegesen átirányítva */
    Header( "Location: http://www.siofokiallatvedo.hu/pethodat/viewer.m/" ); /* hova van átirányítva */
    exit; /* Biztossá teszi azt, hogy az következő kódrész nem fut le. */
}

	session_start();

	// CONNECT TO DATABASE
	require_once('config.php');
	require_once('../function.php');
	
	$Lang = (isset($_GET['Lang'])) ? $_GET['Lang'] : 'HU';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href="../css/viewer.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Si&oacute;foki &Aacute;llatmenhely</title>
    <script type="text/javascript" src="../js/jquery-1.6.4.js"></script>
    <script type="text/javascript" src="../js/jutil.js"></script>
	<script>
			
		function Next(ID,dogID){
			ClosePopup('ind');
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
						var ajaxDisplay = document.getElementById('DogGuest');
						ajaxDisplay.innerHTML = ajaxRequest.responseText;
				}
			}
			document.getElementById('BackLink').style.display= "inline";
			var queryString = '?ID=' + ID + '&dogID=' + dogID + '&Lang=<?php print $Lang;?>';
			ajaxRequest.open('GET', 'guest-data.php'+ queryString, true);
			ajaxRequest.send(null); 
		};
		
		function filter(){
			document.getElementById('BackLink').style.display= "none";
			var ajaxRequest;  // The variable that makes Ajax possible!
			var Filter = document.getElementById('filter');
			var Sex = document.getElementById('Sex');
			var Hair = document.getElementById('hair');
			
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
						var ajaxDisplay = document.getElementById('DogGuest');
						ajaxDisplay.innerHTML = ajaxRequest.responseText;
				}
			}
			var id = document.forms["FiltForm"];
			var queryString = '?Sex=' + id.Iv.value + '&FILTER=' + id.Filt.value + '&Hair=' + id.Szor.value + '&Size=' + id.Mar.value + '&IvD=' + id.IvD.value + '&Stat=' + id.Stat.value + '&Lang=<?php print $Lang;?>';
			ajaxRequest.open('GET', 'guest-filter.php'+ queryString, true);
			ajaxRequest.send(null); 
			//window.alert(queryString);
		};
		
		function SetLang(LangID) {
			location.href='?Lang=' + LangID;
		}
		
		$(document).keyup(function(e) {
			if (e.keyCode == 27) { ClosePopup('Kep'); }   // esc
		});
		
	</script>
    
</head>

<body>
	<div id="ind" style="position: absolute; z-index:2; display:none"><img src="no-photo.jpg" id="imageshow" width="150px"></div>
	<div id="blanket" style="display:none;"></div>
	
    <div id="GuestHeader">
        <div id="left">
            <a href="javascript:SetLang('HU');"><img src="../images/zaszlo_magyar.gif" width="35" height="25" title="Magyar" border="0" /></a> 
            <a href="javascript:SetLang('DE');"><img src="../images/zaszlo_nemet.gif" width="35" height="25" title="Deutsche" border="0" /></a> 
            <a href="javascript:SetLang('EN');"><img src="../images/zaszlo_angol.gif" width="35" height="25" title="English" border="0" /></a>
            <img src="../images/header-<?php print $Lang;?>.png" height="25" title="" border="0" />
        </div>
        <div id="BackLink" style="display:none">
            <a href="javascript:filter()"><?php print DataName('G22',$Lang);?></a>
        </div>
    </div>
    
    <div id="GuestPage">
	   	<div id="GuestFiltForm" class="floatc">
    	<form name="FiltForm">
            <b><?php print DataName('G01',$Lang);?>: </b><input id="Filt" type="text" size="30" onkeyup="javascript:filter();" class="textfield" /><br />
            <table width="990">
            	<tr>
                	<td width="195"><b><?php print DataName('G02',$Lang);?>: </b></td>
                    <td width="195"><b><?php print DataName('G03',$Lang);?>: </b></td>
                    <td width="200"><b><?php print DataName('SZ0',$Lang);?>: </b></td>
                    <td width="200"><b><?php print DataName('G24',$Lang);?>: </b></td>
                    <td width="200"><b><?php print DataName('G11',$Lang);?>: </b></td>
                </tr>
                <tr>
                    <td><select id="Iv" onchange="javascript:filter();" class="textfield">
                <option value=""><?php print DataName('ALL',$Lang);?></option>
                <option value="SE0"><?php print DataName('SE0',$Lang);?></option>
                <option value="SE1"><?php print DataName('SE1',$Lang);?></option>
            </select></td>
                   <td><select id="Szor" onchange="javascript:filter();" class="textfield">
                <option value=""><?php print DataName('ALL',$Lang);?></option>
                <option value="H0"><?php print DataName('H0',$Lang);?></option>
                <option value="H1"><?php print DataName('H1',$Lang);?></option>
                <option value="H2"><?php print DataName('H2',$Lang);?></option>
               </select></td>
               		<td><select id="Mar" onchange="javascript:filter();" class="textfield">
                <option value=""><?php print DataName('ALL',$Lang);?></option>
                <option value="SZ1"><?php print DataName('SZ1',$Lang);?></option>
                <option value="SZ2"><?php print DataName('SZ2',$Lang);?></option>
                <option value="SZ3"><?php print DataName('SZ3',$Lang);?></option>
               </select></td>
               		<td><select id="IvD" onchange="javascript:filter();" class="textfield">
                <option value=""><?php print DataName('ALL',$Lang);?></option>
                <option value="1"><?php print DataName('YES',$Lang);?></option>
                <option value="0"><?php print DataName('NO',$Lang);?></option>
            </select></td>
               		<td><select id="Stat" onchange="javascript:filter();" class="textfield">
                     <option value=""><?php print DataName('ALL',$Lang);?></option>
                     <option value="ST2"><?php print DataName('ST2',$Lang);?></option>
                	 <option value="ST3"><?php print DataName('ST3',$Lang);?></option>
                     <option value="ST1"><?php print DataName('ST1',$Lang);?></option>
            </select></td>
               </tr>
              </table>
            </form>
           	</div>
    
		<div id="DogGuest" class="floatc">
			<script>filter();</script>
		</div>
	</div>

	<div id="GuestFooter">
    	<b><i>Si&oacute;foki  &Aacute;llatv&eacute;dő Alap&iacute;tv&aacute;ny / Tel: +36(20)922-3562 / siofokiallatvedo@gmail.com</i></b> <br />
        <i>Supported browsers: Firefox, Chrome</i> 
    </div>
</body>
</html>