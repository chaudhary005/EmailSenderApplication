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
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
}
require __DIR__. '/partials/_dbconnect.php';
$id=$_SESSION['id'];
$sql="SELECT * FROM `users` WHERE `sno`='$id'";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
$sub=$row['sub'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php require __DIR__. '/partials/_header.php'; ?>
    <hr>
    <hr>
    <?php
        echo '<b>Welcome '.$_SESSION['username'].'<br>';
    
    if ($sub=='y') {
        echo 'To UNSUBSCRIBE to email updates 
        <a href="_unsub.php?uid='.$id.'">click here</a>';
    } else {
        echo 'To SUBSCRIBE to email updates 
        <a href="_sub.php?uid='.$id.'">click here</a>';
    }
    ?>
</body>
</html>