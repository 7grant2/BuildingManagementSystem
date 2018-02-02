<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "root";
$dbName = "bms";
$port = 8889;

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