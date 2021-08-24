<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projectrt";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Database connection error!!");
}


?>