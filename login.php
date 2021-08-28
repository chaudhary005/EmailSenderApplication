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

$login=false;
$showError=false;
$value = isset($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    include __DIR__. 'partials/_dbconnect.php';

    if (!empty($_POST['email'])) {
        $useremail=mysqli_real_escape_string($conn, $_POST['email']);
        if (isset($_POST['password'])) {
            $password=mysqli_real_escape_string($conn, $_POST['password']);
            $password= str_replace("<", "&lt;", $password);
            $password= str_replace(">", "&gt;", $password);
        }
        
        $sql="SELECT * FROM `users` WHERE `email` = '$useremail'";
        $result = mysqli_query($conn, $sql);
        $numRow=mysqli_num_rows($result);
        if ($numRow==1) {
            while ($row=mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    if ($row['status']=='active') {
                        $login=true;
                        session_start();
                        $_SESSION['loggedin']=true;
                        $_SESSION['username']=$row['username'];
                        $_SESSION['id']=$row['sno'];
                        $_SESSION['sub']=$row['sub'];
                        header('location: index.php?uid='.$_SESSION['id']);
                    } else {
                        $showError="Please verify your email to activate 
                        your account.";
                    }
                } else {
                    $showError="Invalid Credentials";
                }
            }
        } else {
            $showError="Invalid Credentials";
        }
    } else {
        $showError="Please enter the details";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php require __DIR__. '/partials/_header.php'; ?>
    <hr>
    <?php
    if ($showError) {
        echo "<strong>Error! ".$showError."</strong>";
    }
    ?>
    <hr>
    <h2>Login to your account.</h2>
    <form action="login.php" method="POST">
        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" style="width: 25vw;">
        </div><br>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" 
            id="password" style="width: 25vw;">
        </div><br>
        <input type="submit" value="Login">
    </form>


    <br><br><div>
        <a href="emailsending.php"><button id="btnClick">Send Email</button></a>
    </div>
</body>
</html>