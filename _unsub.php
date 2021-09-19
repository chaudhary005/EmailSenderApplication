<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: login_unsub.php');
    exit();
}
require __DIR__. '/partials/_dbconnect.php';
$id = $_SESSION['id'];
$value = isset($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['choice'])) {
        $check = $_POST['choice'];
        if ($check == 'n') {
            $sql = "UPDATE `users` SET `sub` = 'n' WHERE `sno` = '$id'";
            $result = mysqli_query($conn, $sql);
            header('location: afterUnsub.php');
            exit();
        } else {
            header('location: index.php');
            exit();
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
    <title>Unsubscribe</title>
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
    #container{
        position: relative;
        display: block;
        top: 8vh;
        padding: 0 0 0 3vw;
        font-size: 20px;
    }
    a:visited{
        color: black;
    }
    a:link{
        color: black;
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
        <form action="_unsub.php?uid='.$id.'" method="POST">
            <div>Do you want to UNSUBSCRIBE to our email updates?<br>
                <br><input type="radio" name="choice" id="yes" value="n">
                <label for="yes">Yes</label>
                <input type="radio" name="choice" id="no" value="y">
                <label for="no">No</label>
            </div><br>
            <input type="submit" value="Submit">
        </form>
        ';
        ?>
    </div>
</body>

</html>