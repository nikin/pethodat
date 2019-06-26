<?php
//Include database connection details
	require_once('../auth.php');
	require_once('../function.php');
	
//Sanitize the POST values
	$Name = clean($_GET['Name']);
	$Szigsz = clean($_GET['Szigsz']);
	$Email = clean($_GET['Email']);
	$Tel = clean($_GET['Tel']);
	$Pcode = clean($_GET['Pcode']);
	$City = clean($_GET['City']);
	$Address = clean($_GET['Address']);
	$Comment = clean($_GET['Comment']);

	$SaveQRY = "INSERT INTO owner SET
						NAME = '" .  $Name . "',
						SZIGSZ = '" .  $Szigsz . "',
						EMAIL = '" .  $Email . "',
						TEL = '" .  $Tel . "',
						P_CODE = '" .  $Pcode . "',
						CITY = '" .  $City . "',
						ADDRESS = '" .  $Address . "',
						COMMENT = '" .  $Comment . "'";
	$SAVEresult = @mysql_query($SaveQRY);
	
	$OWqry="SELECT * FROM owner ORDER BY NAME";
	$OWresult=mysql_query($OWqry);

	print "<select name=\"Owners\" id=\"Owners\" size=\"3\" onchange=\"javascript:ShowOwner(this.value)\">";
				while ($Owners = mysql_fetch_assoc($OWresult)) {
					print "<option value=\"".$Owners['OWNER_ID']."\">".$Owners['NAME']."</option>";
				}
	print"</select>";

?>