<?php

$servername = 'example_server';
$username = 'example_name';
$password = 'example_password';
$database = 'example_database_name';

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die('Database connection error!!');
}


?>