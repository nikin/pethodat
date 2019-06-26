<?php 
ini_set('display_errors', true);
session_start();
print_r($_SESSION);
echo '<hr>';
$_SESSION['sdsad']='dasdas';
print_r($_SESSION);


echo  phpinfo(); 
?>
