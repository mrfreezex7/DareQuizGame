<?php  

$SERVER_NAME = "localhost";
$SERVER_USERNAME = "root";
$SERVER_PASSWORD ="";
$SERVER_DATABASE_NAME = "daregame";


$conn =  mysqli_connect($SERVER_NAME,$SERVER_USERNAME,$SERVER_PASSWORD,$SERVER_DATABASE_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";


?>