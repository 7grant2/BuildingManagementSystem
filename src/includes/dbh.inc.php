<?php
/*
$dbhost = 'localhost';  // Most likely will not need to be changed
$dbname = 'glanham2015';   // Needs to be changed to your designated table database name
$dbuser = 'glanham2015';   // Needs to be changed to reflect your LAMP server credentials
$dbpass = 'hbnuAQ8+o7'; // Needs to be changed to reflect your LAMP server credentials

root root
bms bms
bmssec bmssec
random random
ems ems
*/

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "root";
$dbName = "bms";
//$port = 8888;

$conn = mysqli_connect($dbServername,$dbUsername, $dbPassword, $dbName);
if(!$conn){
    echo "Error: Connection Failed.";
} 

/*
$success = mysqli_real_connect(
   $link, 
   $host, 
   $user, 
   $password, 
   $db,
   $port
);
*/

?>