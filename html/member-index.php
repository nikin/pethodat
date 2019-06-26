<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu-hu" lang="hu-hu" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
	<link href="css/table.css" rel="stylesheet" type="text/css" />
    <link type="text/css" href="css/start/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.6.4.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="js/timeout.js"></script>
    <script type="text/javascript" src="js/jutil.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#bef_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#bdate").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#iv_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
			$( "#tabs" ).tabs();
    	});
		
		$(document).ready(function(){
    		$(document).idleTimeout({});
  		});
    </script>
	<script type="text/javascript" charset="utf-8">
				$(document).ready(function() {
					$('#tabla').dataTable( {
						"aaSorting": [[ 4, "desc" ]]} );
				} );
			</script>   
	<title>Member Index</title>
</head>

<body>
<div id="blanket" style="display:none;"></div>
<?php
//Include database connection details
	require_once('auth.php');
	require_once('function.php');

	if(!isset($_GET['oldal'])) {
		$oldal='-';
	}
	else {
		$oldal = $_GET['oldal'];
	}
	
	// csak betuket s szmokat szeretnnk!
	$pattern = '!^[a-zA-z0-9--]+$!i';

	if (preg_match($pattern, $oldal)) {
		$file = $oldal . ".php";
	
		// Csak akkor include-oljuk a fájlt, ha ltezik: 
		if(file_exists($file)){

			// include-ols 
			$page = $file;
			if ($oldal == "data") { $current = 1;}
			if ($oldal == "ujalat") { $current = 2;}
			if ($oldal == "admin") { $current = 3;}
			if ($oldal == "member-admin") { $current = 4;}
			$active[$current] ="class = 'active'";
		}
		else {
			// klnben hibazenet 
			//echo "Hiba - a fájl nem létezik!";
		}
	}
	else {
		echo "Hiba - tiltott include!";
	} 
	
	print "
	<div id='menu'>
		<ul>
			<li><a href=\"member-index.php?oldal=search\"><img title='Keresés az adatbázisban' src=\"images/search.png\" width=\"40\" height=\"40\" border=\"0\"></a></li>
			<li><a href=\"member-index.php?oldal=ujalat\"><img title='Új kutya regisztrálása' src=\"images/new.png\" width=\"40\" height=\"40\" border=\"0\"></a></li>
			<li><a href=\"member-index.php?oldal=o-admin\"><img title='Örökbefogadók karbantartása' src=\"images/edituser.png\" width=\"40\" height=\"40\" border=\"0\"></a></li>";
			if ($_SESSION['RIGHTS'] == 2) {
				print "<li><a href=\"member-index.php?oldal=admin\"><img title='Felhasználók karbantartása' src=\"images/admin.png\" width=\"40\" height=\"40\" border=\"0\"></a></li>";
			}
			print"
			<li><a href=\"logout.php\"><img title='Kilépés' src=\"images/exit.png\" width=\"40\" height=\"40\" border=\"0\"></a></li>
			<li><jobb>".$_SESSION['SESS_NAME']."</jobb></li>
		</ul>
		</div>
		<div id='page'>";
			if(file_exists($file)){
				include("$file");
			}
		print "</div>
		</div>";
?>
</body>
</html>