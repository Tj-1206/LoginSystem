<!-- This file contains the code for connecting to the database -->

<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "users";

$conn = mysqli_connect($server, $username, $password, $database);

if(!$conn){
    die("Failed to connect to phpMyAdmin! - " . mysqli_connect_error());
}
?>