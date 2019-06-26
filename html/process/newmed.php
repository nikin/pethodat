<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
//Retrieve form data. 
//GET - user submitted data using AJAX
//POST - in case user does not support javascript, we'll use POST instead
	$dogID = ($_GET['dogID']) ? $_GET['dogID'] : $_POST['dogID'];
	$mDate = ($_GET['mDate']) ? $_GET['mDate'] : $_POST['mDate'];
	$mType = ($_GET['mType']) ?$_GET['mType'] : $_POST['mType'];
	$Doctor = ($_GET['Doctor']) ?$_GET['Doctor'] : $_POST['Doctor'];
	$mDesc = ($_GET['mDesc']) ?$_GET['mDesc'] : $_POST['mDesc'];
		
	$MSqry = "INSERT INTO medical SET
				DOG_ID = '" .  $dogID . "',
				DATE = '" .  $mDate . "',
				TYPE = '" .  $mType . "',
				M_DESC = '" .  $mDesc . "',
				DOCTOR = '" .  $Doctor . "'";
	$MSresult = @mysql_query($MSqry);
	
	// Ivartalanítás dátumának mentésa a kutya adatbázisba!!
	if ($mType == 'M1') {
		$IVqry = "UPDATE dogs SET
				IV_DATE = '" .  $mDate . "',
				IV = '1'
				WHERE DOG_ID = '".$dogID."'";
		$IVresult = @mysql_query($IVqry);
	}
	
	$Mqry="SELECT * FROM medical WHERE DOG_ID='".$_SESSION['dogID']."'";
	$Mresult=mysql_query($Mqry);
		
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
		print "<tr height='20'></tr>
			</table>";
?>