<?php
session_start();

$_SESSION["logOnAttempt"] = 0;
$_SESSION["loginWarn"] = "You are logged out.";
$_SESSION["loggedIn"] = false;
unset($_SESSION['adminID']);//these can be blown up. will be reset later on log in.
unset($_SESSION['adminFName']);//these can be blown up. will be reset later on log in.
unset($_SESSION['adminLName']);//these can be blown up. will be reset later on log in.
unset($_SESSION['adminAuthLevel']);//these can be blown up. will be reset later on log in.
mysql_close(); //closes connection to sql db.
header('Location: '.'LogIn.php');//send user back to login.
?>