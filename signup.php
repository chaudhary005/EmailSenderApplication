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

$showError=false;
$showSuccess=false;
$value = isset($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include __DIR__. 'partials/_dbconnect.php';
    
    empty($_POST['username']);
    $username= mysqli_real_escape_string($conn, $_POST['username']);
    $username= str_replace("<", "", $username);
    $username= str_replace(">", "", $username);
    $username= str_replace(";", "", $username);

    $useremail=mysqli_real_escape_string($conn, $_POST['email']);
    $useremail= str_replace("<", "", $useremail);
    $useremail= str_replace(">", "", $useremail);
    $useremail= str_replace(";", "", $useremail);

    $password=mysqli_real_escape_string($conn, $_POST['password']);
    $password= str_replace("<", "&lt;", $password);
    $password= str_replace(">", "&gt;", $password);

    $cpassword=mysqli_real_escape_string($conn, $_POST['cpassword']);
    $cpassword=str_replace("<", "&lt;", $cpassword);
    $cpassword=str_replace(">", "&gt;", $cpassword);
    $sub=$_POST['sub'];
    $token=bin2hex(random_bytes(15));

    //check no entry should be blank
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        $showError="Please enter all the details";
    } else {
        //if user exist
        $sqlexist="SELECT * FROM `users` WHERE `email`='$useremail'";
        $result2 = mysqli_query($conn, $sqlexist);
        $numRows=mysqli_num_rows($result2);
        if ($numRows>0) {
            $showError="User already exists!";
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
                    $subject="Account Verification!";
                    $headers="From: chaudharyshivmalan@gmail.com";
                    $body="Hi , $username. Click here to activate your account 
                    http://localhost/rtCamp/activate.php?token=$token";
                    if (mail($to_email, $subject, $body, $headers)) {
                        header('location: login_verify.php');                     
                    }
                }
            } else {
                $showError="Passwords do not match!";
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
</head>
<body>
    <?php require __DIR__. '/partials/_header.php'; ?>
    
    <hr><?php 
    if ($showSuccess) {
        echo "<strong>Great! ".$showSuccess."</strong><br>";
    }
    if ($showError) {
        echo "<strong>Error! ".$showError."</strong><br>";
    }
    ?><hr>
    <h2>SignUp for to create new account</h2>
    <form action="signup.php" method="POST">
        <div>
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" style="width: 25vw;">
        </div><br>
        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email"style="width: 25vw;"><br>
            <small>We'll never share your email.</small>
        </div><br>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password"style="width: 25vw;">
        </div><br>
        <div>
            <label for="cpassword">Password</label><br>
            <input type="password" name="cpassword" 
            id="cpassword"style="width: 25vw;">
            <input type="hidden" name="sub" value="y">
        </div><br>
        <input type="submit" name="submit" value="SignUp">
    </form>

</body>
</html>