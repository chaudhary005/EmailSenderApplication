<?php

session_start();
require __DIR__. '/partials/_dbconnect.php';
if (isset($_GET['token'])) {
    $token_val = $_GET['token'];
    $token = filter_var($token_val, FILTER_SANITIZE_STRING);
    $sql_update = "UPDATE `users` SET `status` = 'active'
     WHERE `users`.`token`='$token'";
    $result_update = mysqli_query($conn, $sql_update);
    header('location: login.php');
    exit();
}

?>