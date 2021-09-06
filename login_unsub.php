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

/**
 * {@inheritdoc}
 * 
 * @param $data The value to be passes
 * 
 * @return string
 */
function Test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


$value = isset($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    include __DIR__. '/partials/_dbconnect.php';

    if (isset($_POST['email'])) {
        $useremail = Test_input($_POST['email']);
        if (isset($_POST['password'])) {
            $password = Test_input($_POST['password']);
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
                        header("location: _unsub.php?uid=".$_SESSION['id']);
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
        background-color: lightgray;
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
                echo "<strong>Error! ".$showError."</strong>";
            }
            ?>
        </div>
        <hr>
    </div>
    <div id="container">
        <h2>Login to your account.</h2>
        <div>
            <form action=<?php echo htmlspecialchars("login_unsub.php"); ?> method="POST">
                <div id="form">
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email" style="width: 25vw;">
                </div><br>
                <div>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="password" style="width: 25vw;">
                </div><br>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>

</html>