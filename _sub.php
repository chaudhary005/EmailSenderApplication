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
    if (isset($_POST['choice'])) {
        $check = $_POST['choice'];
        if ($check == "y") {
            $sql = "UPDATE `users` SET `sub` = 'y' WHERE `sno` = '$id'";
            $result = mysqli_query($conn, $sql);
            header('location: index.php');
        } else {
            header('location: index.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe</title>
    <style>
    hr {
        margin: 2px;
    }
    body{
        background-color: lightslategray;
    }

    #header {
        position: relative;
        display: block;
        font-size: larger;
        top: 5vh;
        padding: 0 2vw;
    }

    #container {
        position: relative;
        display: block;
        top: 8vh;
        padding: 0 0 0 3vw;
        font-size: 20px;
    }
    </style>
</head>

<body>
    <div id="header">
        <?php require __DIR__. '/partials/_header.php'; ?>
        <hr>
        <hr>
    </div>
    <div id="container">
        <?php
        echo '
        <form action="_sub.php?uid='.$id.'" method="POST">
            <div>Do you want to SUBSCRIBE to our comic emails?<br>
                <br><input type="radio" name="choice" id="yes" value="y">
                <label for="yes">Yes</label>
                <input type="radio" name="choice" id="no" value="n">
                <label for="no">No</label>
            </div><br>
            <input type="submit" value="Submit">
        </form>
        ';
        ?>
    </div>
</body>

</html>