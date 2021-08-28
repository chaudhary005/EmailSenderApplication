<?php
/**
 * MyClass File Doc Comment
 * 
 * PHP version 8.0.6
 * 
 * @category MyClass
 * @package  MyPackage
 * @author   Author <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

session_start();
require __DIR__. '/partials/_dbconnect.php';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql_update = "UPDATE `users` SET `status` = 'active'
     WHERE `users`.`token`='$token'";
    $result_update = mysqli_query($conn, $sql_update);
    header('location: login.php');
}

?>