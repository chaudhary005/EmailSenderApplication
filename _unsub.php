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
$id = $_SESSION['id'];
$value = isset($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD']=="POST") {

    $check = $_POST['choice'];
    if ($check == "n") {
        $sql = "UPDATE `users` SET `sub` = 'n' WHERE `sno` = '$id'";
        $result = mysqli_query($conn, $sql);
        header('location: afterUnsub.php');
    } else {
        header('location: index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribe</title>
</head>
<body>
    
    <?php require __DIR__. '/partials/_header.php'; ?>
    <hr>
    <hr>
    <?php
    echo '
    <form action="_unsub.php?uid='.$id.'" method="POST">
        <div>Do you want to UNSUBSCRIBE to our email updates?<br>
            <input type="radio" name="choice" id="yes" value="n">
            <label for="yes">Yes</label>
            <input type="radio" name="choice" id="no" value="y">
            <label for="no">No</label>
        </div><br>
        <input type="submit" value="Submit">
    </form>
    ';
    ?>
</body>
</html>