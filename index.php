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
        padding: 0 3vw;
        font-size: 20px
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
        echo '<b>Welcome '.$_SESSION['username'].'<br>'; 
        ?>
        <i><br><big><b>Laughter is the best medicine. </b></big></i>It’s true: laughter is strong medicine. It draws
        people
        together in ways that trigger healthy physical and emotional changes in the body. Laughter strengthens your
        immune
        system, boosts mood, diminishes pain, and protects you from the damaging effects of stress. Nothing works faster
        or
        more dependably to bring your mind and body back into balance than a good laugh. Humor lightens your burdens,
        inspires hope, connects you to others, and keeps you grounded, focused, and alert. It also helps you release
        anger
        and forgive sooner.<br>

        <br>With so much power to heal and renew, the ability to laugh easily and frequently is a tremendous resource
        for
        surmounting problems, enhancing your relationships, and supporting both physical and emotional health. Best of
        all,
        this priceless medicine is fun, free, and easy to use.<br>

        <br>As children, we used to laugh hundreds of times a day, but as adults, life tends to be more serious and
        laughter
        more infrequent. But by seeking out more opportunities for humor and laughter, you can improve your emotional
        health, strengthen your relationships, find greater happiness—and even add years to your life.<br>

        <b><br>Therefore, to boost your healthy life, we will send you some comics to make you laugh and stay
            healthy.</b><br><br>


        <?php if ($sub=='y') {
            echo 'To UNSUBSCRIBE to email updates &nbsp;
            <a href="_unsub.php?uid='.$id.'">click here</a>';
        } else {
            echo 'To SUBSCRIBE to email updates &nbsp; 
            <a href="_sub.php?uid='.$id.'">click here</a>';
        }
        ?>
    </div>
</body>

</html>