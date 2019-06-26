<?php
	session_start();

	// CONNECT TO DATABASE
	require_once('config.php');
	require_once('../function.php');
	
	$Lang = $_GET['Lang'];
	
	if (!isset($Lang)){
		$Lang = 'HU';
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href="../css/styles.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Siófoki Állatmenhely</title>
    <script type="text/javascript" src="../js/jquery-1.6.4.js"></script>
    <script type="text/javascript" src="../js/jutil.js"></script>
	<script>
		var posx;var posy;
		
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
			var queryString = '?Sex=' + id.Iv.value + '&FILTER=' + id.Filt.value + '&Hair=' + id.Szor.value + '&Size=' + id.Mar.value + '&Lang=<?php print $Lang;?>';
			ajaxRequest.open('GET', 'guest-filter.php'+ queryString, true);
			ajaxRequest.send(null); 
		};
		
		function SetLang(LangID) {
			location.href='?Lang=' + LangID;
		}
		
		$(document).keyup(function(e) {
			if (e.keyCode == 27) { ClosePopup('Kep'); }   // esc
		});
		
	function showIt(img,e){
		document.getElementById('ind').style.display = 'block';
		imgsrc = 'http://pethodat.siofokiallatvedo.hu/pictures/'+img+'.jpg';
		document.getElementById('imageshow').src=imgsrc;
	
		var ind = 'ind';
		posx=0;posy=0;
		var myWidth=document.documentElement.clientWidth;
		var myHeight=document.documentElement.clientHeight;
		var ev=(!e)?window.event:e;//Moz:IE
		if (ev.pageX){posx=ev.pageX;posy=ev.pageY;}//Mozilla or compatible
		else if(ev.clientX){posx=ev.clientX;posy=ev.clientY;}//IE or compatible
		else{return false}//old browsers
	
		if (posx > (myWidth-150)){posx = posx-100;}
			else {posx = posx+20;}
		if (posy > (myHeight-150)) {posy = posy-150;}
			else {posy = posy+20;}

		document.getElementById(ind).style.left = posx+"px";
		document.getElementById(ind).style.top = posy+"px";
	}
	</script>
    
</head>

<body>
	<div id="ind" style="position: absolute; z-index:2; display:none"><img src="no-photo.jpg" id="imageshow" width="150px"></div>
	<div id="blanket" style="display:none;"></div>
	<div id="guest">
        <div id="GuestLeft">
            <a href="javascript:SetLang('HU');"><img src="../images/zaszlo_magyar.gif" width="35" height="25" title="Magyar" border="0" /></a> 
            <a href="javascript:SetLang('DE');"><img src="../images/zaszlo_nemet.gif" width="35" height="25" title="Deutsche" border="0" /></a> 
            <a href="javascript:SetLang('EN');"><img src="../images/zaszlo_angol.gif" width="35" height="25" title="English" border="0" /></a>
        </div>
        <div id="GuestCenter">
        	<form name="FiltForm">
            <b><?php print DataName('G01',$Lang);?>: </b><input id="Filt" type="text" size="35" onkeyup="javascript:filter();" class="textfield" />
            <b><?php print DataName('G02',$Lang);?>: </b><select id="Iv" onchange="javascript:filter();" class="textfield">
                <option value=""><?php print DataName('ALL',$Lang);?></option>
                <option value="SE0"><?php print DataName('SE0',$Lang);?></option>
                <option value="SE1"><?php print DataName('SE1',$Lang);?></option>
            </select>
            <b><?php print DataName('G03',$Lang);?>: </b><select id="Szor" onchange="javascript:filter();" class="textfield">
                <option value=""><?php print DataName('ALL',$Lang);?></option>
                <option value="H0"><?php print DataName('H0',$Lang);?></option>
                <option value="H1"><?php print DataName('H1',$Lang);?></option>
                <option value="H2"><?php print DataName('H2',$Lang);?></option>
               </select>
            <b><?php print DataName('SZ0',$Lang);?>: </b><select id="Mar" onchange="javascript:filter();" class="textfield">
                <option value=""><?php print DataName('ALL',$Lang);?></option>
                <option value="SZ1"><?php print DataName('SZ1',$Lang);?></option>
                <option value="SZ2"><?php print DataName('SZ2',$Lang);?></option>
                <option value="SZ3"><?php print DataName('SZ3',$Lang);?></option>
               </select>
            </form>
         </div>
         <div id="BackLink" style="display:none">
            <a href="javascript:filter()"><?php print DataName('G22',$Lang);?></a>
         </div>
    </div>
	<div id="DogGuest" class="floatc">
		<script>filter();</script>
	</div>
    
	<div id="footer"><b><i>Siófoki  Állatvédő Alapítvány / Tel: +36(20)922-3562 / siofokiallatvedo@gmail.com</i></b></div>
</body>
</html>