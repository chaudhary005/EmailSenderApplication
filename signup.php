<?php

$showError=false;

require __DIR__. '/test_function.php';
$value = isset($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include __DIR__. '/partials/_dbconnect.php';
    
    if (isset($_POST['username'])) {
        $name = Test_input($_POST['username']);
        $username = filter_var($name, FILTER_SANITIZE_STRING);
    }

    if (isset($_POST['email'])) {
        $email = Test_input($_POST['email']);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === true){
            $useremail = $email;
        }
    }

    if (isset($_POST['password'])) {
        $pass = Test_input($_POST['password']);
        $password = filter_var($pass, FILTER_SANITIZE_STRING);
    }

    if (isset($_POST['cpassword'])) {
        $cpass = Test_input($_POST['cpassword']);
        $cpassword = filter_var($cpass, FILTER_SANITIZE_STRING);
    }

    if (isset($_POST['sub'])) {
        $sub = Test_input($_POST['sub']);
        $sub = filter_var($sub, FILTER_SANITIZE_STRING);
    }
    $token=bin2hex(random_bytes(15));
    

    //check no entry should be blank
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        $showError='Please enter all the details';
    } else {
        //if user exist
        $sqlexist="SELECT * FROM `users` WHERE `email`='$useremail'";
        $result2 = mysqli_query($conn, $sqlexist);
        $numRows=mysqli_num_rows($result2);
        if ($numRows>0) {
            $showError='User already exists!';
        } else {
            if ($password==$cpassword) {
                $hash=password_hash($password, PASSWORD_DEFAULT);
                $sql= "INSERT INTO `users` (`username`, `email`, `password`, 
                `sub`, `token`, `status`, `timestamp`) VALUES ('$username', 
                '$useremail', '$hash', '$sub', '$token', 'inactive', 
                current_timestamp())";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $to_email=$useremail;        
                    $subject = 'Account Verification!';
                    
                    if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)) {
                    $protocol = 'https://';
                    }
                    else {
                    $protocol = 'http://';
                    }
                    if (isset($_SERVER['HTTP_HOST'])){
                        $server = $_SERVER['HTTP_HOST'];
                    }
                    $protocol .= $server;
                    $protocol .= '/activate.php';
                        
                    $body="Hi , $username. \r\n";
                    $body .= "Click here to activate your account 
                    $protocol?token=$token";
                    
                    $headers = 'MIME-Version: 1.0 \r\n';
                    $headers .= 'Content-type:text/html;charset=UTF-8 \r\n';
                    
                    if (mail($to_email, $subject, $body, $headers)) {
                        header('location: login_verify.php');
                        exit();                   
                    }
                }
            } else {
                $showError='Passwords do not match!';
            }
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
    <title>SignUp</title>
    <style>
    hr {
        margin: 1px;
    }
    body{
        background-color: lightslategray;
    }

    #header {
        position: relative;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 70%;
        font-size: larger;
        top: 5vh;
    }

    #container {
        position: relative;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding: 50px;
        width: 26%;
        top: 15vh;
        border: 2px solid black;
        border-radius: 10px;
        background-color: lightgray
    }
    #msg {
        padding: 0 0 0 23vw;
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
        <div id="msg">
            <?php 
            if ($showError) {
                echo '<strong>Error! '.$showError.'</strong><br>';
            }
            ?>
        </div>
        <hr>
    </div>
    <div id="container">
        <h2>SignUp for to create new account</h2>
        <form action="signup.php" method="POST">
            <div>
                <label for="username">Username</label><br>
                <input type="text" name="username" id="username" style="width: 25vw;">
            </div><br>
            <div>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" style="width: 25vw;"><br>
                <small>We'll never share your email.</small>
            </div><br>
            <div>
                <label for="password">Password</label><br>
                <input type="password" name="password" id="password" style="width: 25vw;">
            </div><br>
            <div>
                <label for="cpassword">Password</label><br>
                <input type="password" name="cpassword" id="cpassword" style="width: 25vw;">
                <input type="hidden" name="sub" value="y">
            </div><br>
            <input type="submit" name="submit" value="SignUp">
        </form>
    </div>

</body>

</html>