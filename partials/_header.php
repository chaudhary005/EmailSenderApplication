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

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
    $loggedin=true;
} else {
    $loggedin=false;
}
echo '<nav>
    <ul style="list-style-type: none; padding-left: 20px;">
        <li><a style="text-decoration: none;" href="index.php">Home</a></li>';
if (!$loggedin) {
    echo '<li><a style="text-decoration: none;" href="signup.php">SignUp</a></li>
    <li><a style="text-decoration: none;" href="login.php">Login</a></li>';
}

if ($loggedin) {
    echo '<li><a style="text-decoration: none;" href="logout.php">Logout</a></li>';
}
    echo '</ul
</nav>';

?>