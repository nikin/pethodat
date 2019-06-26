<?php
session_start();
$uploaddir = '../pictures/'; 
$file_name = $_GET['dogID'].".jpg";

$file = $uploaddir . $file_name; 

	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
  		echo $_SESSION['dogID']; 
	} 
	else {
		echo "error";
	}
?>