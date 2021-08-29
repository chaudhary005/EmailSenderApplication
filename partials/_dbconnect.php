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

$servername = "localhost";
$username = "root";
$password = "";
$database = "projectrt";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Database connection error!!");
}


?>