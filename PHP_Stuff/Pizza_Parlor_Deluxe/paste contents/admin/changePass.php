<?php
session_start();// start a session in order to work with session variables

if(!isset($_SESSION["passChangeAttempt"])){
	$_SESSION["passChangeAttempt"]=0;
}
if ( (!$_SESSION['loggedIn']) || ($_SESSION["logOnAttempt"]>3) || ($_SESSION["passChangeAttempt"]>5) ){
	$_SESSION['loginWarn'] = 'You must be logged into the system to access the page.changePass';
	//$_SESSION["logOnAttempt"] += 1; disabled to avoid issues with testing in the absence of a developer.
	$_SESSION["loggedIn"] = false;
	unset($_SESSION['adminID']);
	unset($_SESSION['adminFName']);
	unset($_SESSION['adminLName']);
	unset($_SESSION['adminAuthLevel']);
	header('Location: '.'LogIn.php');
}
//maybe another security line here about referring directory path must be from ProcessPage.php, but not necessary.
else {
echo '<!DOCTYPE html>
<html lang="en">

<head>
<title>Password Change</title>
       <meta name="author" content="David Regalado">
       <meta name="keywords" content="final project: Pizza Parlor">
       <meta name="description" content="Log in page for Pizza Parlor Deluxe Admin site">
       <meta http-equiv="content-type" content="text/html; charset=UTF-8">
       <meta name="robots" content="none">
       <link rel="stylesheet" href="adminStyle.css" type="text/css">
       <script type="text/javascript" src="admin.js"></script>
       <script type="text/javascript" src="cookies.js"></script>
</head>
<body>
<div id="container">
    <div id="head">
        <img src="../graphics/pizza.jpeg" width="238" height="120" alt="pizza" id="logo">
        <span class="header">PizzaParlorDeluxe.com</span>
        <span class="contact">
            20000 68th Ave. W<br>
            Lynnwood, WA 98036<br>
            425.222.1234
        </span>
    </div>
    
    <div id="break">    
        <hr style="clear:both;margin-top:15px;">
    </div>
    
    <div id="nav">
        <a href="LogIn.php" class="orderSum">Log In</a><br>
        <a href="../PizzaParlor/order.php" class="orderSum" >Place Order</a><br>
    </div>
    <form method="post" action="processPasswordChange.php" onsubmit="return chkForm(0)">
    
    <div id="main">
        <p>
        <h3>Please enter your old password and your new password</h3>
        <p>Passwords must include all of the four types of characters below:</p>
        <ul>
            <li>Upper case letters</li>
            <li>Lower case letters</li>
            <li>Numbers</li>
            <li>Non-alpha characters</li>
            <li>A minimum length of eight characters</li>
        </ul>
		<p>
        Current password: <input type="password" name="pswOld" class="input" value=""> <br>
        New Password: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="pswWord" class="input" value=""><br>
        Confirm Password: <input type="password" name="pswConf" class="input" value=""><br><br>
        <input type="submit" value="submit">
        </p>
        <span id="loginWarn">
            
        </span>
    </div>
    
    </form>
    
</div>
</body>

</html>';
}  // end else
?>