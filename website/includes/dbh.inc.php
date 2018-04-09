<?php
/*
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "root";
$dbName = "bms";


root root
bms bms
bmssec bmssec
random random
ems ems
*/

//$port = 8888;
$dbServername = 'localhost';  // Most likely will not need to be changed
$dbUsername = 'glanham2015';   // Needs to be changed to your designated table database name
$dbName = 'glanham2015';   // Needs to be changed to reflect your LAMP server credentials
$dbPassword = 'hbnuAQ8+o7'; // Needs to be changed to reflect your LAMP server credentials


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
