<?php
include 'config.php';
$DB_USER = "m0000007@localhost";

$backupFile = $DB_DATABASE . date("Y-m-d-H-i-s") . '.sql';
print $command = "mysqldump --opt -h $DB_HOST -u $DB_USER -p $DB_PASSWORD $DB_DATABASE > $backupFile";
system ($command, $result);
echo 'result: ' . $result;
print "end";
?>