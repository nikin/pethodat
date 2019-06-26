 // JavaScript Document

function showAndHideTab(showID,hideID,hideID2) {
		document.getElementById(showID).style.display= "block";
		document.getElementById(hideID).style.display= "none";
		document.getElementById(hideID2).style.display= "none";
		}

function showTab(showID) {
		document.getElementById(showID).style.display= "block";
		}

function hideTab(hideID) {
		document.getElementById(hideID).style.display= "none";
		}

function load_content(url,DiV)
{
$(DiV).load(url);
}

//VISSZALÉPÉS A FŐOLDALRA
function Home(Lang) {
	location.href="member-index.php?oldal=member-main&lang="+Lang;
}

//Viszalépés
function goBack()
  {
  window.history.back()
  }
  
function Show_Popup(ID1, ID2) {
$(ID1).fadeIn('fast');
$(ID2).fadeIn('fast');
}
function Close_Popup(ID1, ID2) {
$(ID1).fadeOut('fast');
$(ID2).fadeOut('fast');
}

function ChangeStatus(stID, dogID){
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
		var queryString = '?dogID=' + dogID + '&stID=' + stID;
			ajaxRequest.open('GET', 'process/changest.php'+ queryString, true);
			ajaxRequest.send(null); 
	};

function toggle(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
}

function blanket_size(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportheight = window.innerHeight;
	} else {
		viewportheight = document.documentElement.clientHeight;
	}
	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
		blanket_height = viewportheight;
	} else {
		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
			blanket_height = document.body.parentNode.clientHeight;
		} else {
			blanket_height = document.body.parentNode.scrollHeight;
		}
	}
	var blanket = document.getElementById('blanket');
	blanket.style.height = blanket_height + 'px';
	var popUpDiv = document.getElementById(popUpDivVar);
	popUpDiv_height=blanket_height/4-100;
	popUpDiv.style.top = popUpDiv_height + 'px';
}
function window_pos(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportwidth = window.innerHeight;
	} else {
		viewportwidth = document.documentElement.clientHeight;
	}
	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
		window_width = viewportwidth;
	} else {
		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
			window_width = document.body.parentNode.clientWidth;
		} else {
			window_width = document.body.parentNode.scrollWidth;
		}
	}
	var popUpDiv = document.getElementById(popUpDivVar);
	window_width=window_width/4-100;
	popUpDiv.style.left = window_width + 'px';
}

function popup(windowname) {
	blanket_size(windowname);
	window_pos(windowname);
	toggle('blanket');
	toggle(windowname);		
}

function ClosePopup(windowname) {
	document.getElementById('blanket').style.display = 'none';
	document.getElementById(windowname).style.display = 'none';	
}

//AJAX REQUEST!!!!
function AjaxReq(){
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
	return(ajaxRequest);
}

//AJAX DISPLAY
function AjaxDisp(ajaxRequest,DiV){
			// Create a function that will receive data sent from the server
				ajaxRequest.onreadystatechange = function(){
						if(ajaxRequest.readyState == 4){
						var ajaxDisplay = document.getElementById(DiV);
						ajaxDisplay.innerHTML = parseScript(ajaxRequest.responseText);
						ajaxDisplay.innerHTML = ajaxRequest.responseText;

				}
			}
		}