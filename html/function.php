<?php

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
// Salt generátor
function salt($number)
	{
	$array = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", 
	"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", 
	1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
	srand((double) microtime() * 1000000);
	$keys = array_rand($array, $number);
	$salt = "";
	while(list($id, $key) = each($keys))
		{
		$salt .= $array[$key];
		}
	return($salt);
	}

//Névkeresés az adatbázisban
function Name($what,$table,$filter1,$filter2) {
	$result=mysql_query("SELECT $what FROM $table WHERE $filter1=$filter2");
	$tmp = mysql_fetch_assoc($result);
	return $tmp[$what];
}

//Hibaüzenet Kiiratása - $_SESSION['ERRMSG']
function DropMSG() {
	print "<script language='Javascript'>
					window.onload = function () {
						alert('".$_SESSION['MSG']."');
						}
			   </script>";
		unset($_SESSION['MSG']);
}

//Oldal Újratöltése
function ReLoad() {
	print "<script language='JavaScript' type='text/javascript'>
		location.reload();
		</script>";
}

//FAJTA MEGHATÁROZÁS
function DataName($ID,$LangID) {
	if (!isset($LangID)){
		$LangID = "HU";
	}
	$result=mysql_query("SELECT * FROM data WHERE ID='$ID'");
	$tmp = mysql_fetch_assoc($result);
	if ($tmp['DATA_'.$LangID] == ''){
		return $tmp['DATA_HU'];
	}
	else{
		return $tmp['DATA_'.$LangID];
	}
}

//ADAT MEGHATÁROZÁS
function DataNameID($ID,$DI) {
	$result=mysql_query("SELECT ID FROM data WHERE DATA LIKE '%".$ID."%' AND ID LIKE '%".$DI."%'");
	while ($data = mysql_fetch_assoc($result)) {
	$tmp['ID'] = $tmp['ID']."'".$data['ID']."',";
	}
	return $tmp['ID'];
}

//ÖRÖKBEFOGADÓ MEGHATÁROZÁSA
function OwnerName($ID) {
	$result=mysql_query("SELECT NAME FROM owner WHERE OWNER_ID='$ID'");
	$tmp = mysql_fetch_assoc($result);
	return $tmp['NAME'];
}

//ÖRÖKBEFOGADÓ MEGHATÁROZÁSA
function OwnerData($ID) {
	$result=mysql_query("SELECT * FROM owner WHERE OWNER_ID='$ID'");
	$data = mysql_fetch_assoc($result);
	$tmp = "Tel.: ".$data['TEL']."; E-mail: ".$data['EMAIL'];
	return $tmp;
}

//USER MEGHATÁROZÁSA
function UserName($ID) {
	$result=mysql_query("SELECT NAME FROM users WHERE USER_ID='$ID'");
	$tmp = mysql_fetch_assoc($result);
	return $tmp['NAME'];
}

function GetSize($size,$Lang){
	if ($size < 35) {
		$tmp = DataName('SZ1',$Lang);
	}
	elseif ($size >= 35 && $size <= 50) {
		$tmp = DataName('SZ2',$Lang);
	}
	else {
		$tmp = DataName('SZ3',$Lang);
	}
	return $tmp;
}

//Ido
function ActTime(){
    $days= (date("j"));
    $months =(date("n"));
    $years =(date("Y"));
    $hours =date("G");
    $mins =date("i");
    $secs =date("s");
    $diff=$years."-".$months."-".$days." ".$hours.":".$mins.":".$secs;
    return $diff;
}

//Kutya neve
function DogName($dogID){
	// Adatbázis elérése
	$qry="SELECT DOG_NAME FROM dogs WHERE DOG_ID='".$dogID."'";
	$result=mysql_query($qry);
	if (mysql_num_rows($result) == 0 ){
		$qry="SELECT DOG_NAME FROM archive_dogs WHERE DOG_ID='".$dogID."'";
		$result=mysql_query($qry);
	}
	$tmp = mysql_fetch_assoc($result);
	return $tmp['DOG_NAME'];
}
?>