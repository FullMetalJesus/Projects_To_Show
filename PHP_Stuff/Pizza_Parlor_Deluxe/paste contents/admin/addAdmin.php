<?php
	session_start();

//-----------security stuff-------------------------
	$refer1 = $_SESSION['addressOne']."/admin/addAdmin.php";//done
	$refer2 = $_SESSION['addressOne']."/admin/deleteAdmin.php";//done
	$refer3 = $_SESSION['addressOne']."/admin/todayOrders.php";//done
	$refer4 = $_SESSION['addressOne']."/admin/allOrders.php";//done
	$refer5 = $_SESSION['addressOne']."/admin/menu.php";//done
	$refer6 = $_SESSION['addressOne']."/admin/processAdminAdd.php";//done
	
	if (($_SERVER['HTTP_REFERER'] != $refer1) && ($_SERVER['HTTP_REFERER'] != $refer2) && ($_SERVER['HTTP_REFERER'] != $refer3) && ($_SERVER['HTTP_REFERER'] != $refer4) && ($_SERVER['HTTP_REFERER'] != $refer5) && ($_SERVER['HTTP_REFERER'] != $refer6) ){//referring page check
		$_SESSION["loginWarn"] = "Referring Page Incorrect.Please try logging in again. addAdmin.php error.";
		$_SESSION["logOnAttempt"] += 1;
		$_SESSION["loggedIn"] = false;
		unset($_SESSION['adminID']);
		unset($_SESSION['adminFName']);
		unset($_SESSION['adminLName']);
		unset($_SESSION['adminAuthLevel']);
		header('Location: '.'LogIn.php');
	}
	
	if(($_SESSION["loggedIn"] == false)){//authorization level check
		$_SESSION["loginWarn"] = "You do not have sufficient permissions to edit on admins page. addAdmin.php";
		$_SESSION["logOnAttempt"] += 1;
		unset($_SESSION['adminID']);
		unset($_SESSION['adminFName']);
		unset($_SESSION['adminLName']);
		unset($_SESSION['adminAuthLevel']);
		header('Location: '.'LogIn.php');
	}
//--------------end of security stuff-------------------
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Pizza Order</title>
       <meta name="author" content="David Regalado">
       <meta name="keywords" content="final project 'Pizza Parlor'">
       <meta name="description" content="Pizza Parlor">
       <meta http-equiv="content-type" content="text/html; charset=UTF-8">
       <meta name="robots" content="none">
	   <script type="text/javascript" src="admin.js"></script>
       <link rel="stylesheet" href="adminStyle.css" type="text/css">
	</head>
	<body>
		<div id="container">
			<div id="head">
				<img src="../graphics/pizza.jpeg" width="238" height="120" alt="Picture of Pizza" id="logo">
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
				<a href="todayOrders.php" class="orderSum">Complete(Today)</a><br>
				<a href="allOrders.php" class="orderSum">Complete(History)</a><br>
				<a href="menu.php" class="orderSum">Admin Menu</a><br>
				<a href="addAdmin.php" class="orderSum">Add New Admin</a><br>
				<a href="deleteAdmin.php" class="orderSum">Delete Admin</a><br>
			</div>
			<div id="main">
				<form method="post" action="processAdminAdd.php" onsubmit="return chkForm(0)">
					<p>Logins, First Names and Last Names MUST:</p>
						<ul>
							<li>Be non blank</li>
							<li>consist of 4 or more characters</li>
						</ul>
					<p>Passwords must have a minimum length of eight characters and include all of the four types of characters below:</p>
						<ul>
							<li>Upper case letters</li>
							<li>Lower case letters</li>
							<li>Numbers</li>
							<li>Non-alpha characters</li>
						</ul>
					<p>
						Please enter new administrator information:<br><br>
						Log In:  <input type="text" name="login" value=""><br>
						First Name:  <input type="text" name="firstName" value=""><br>
						Last Name:  <input type="text" name="lastName" value=""><br>
						Admin Level:  <select name="adminLevel">
										<option value='1' selected="selected">1</option>
										<option value='2'>2</option>
									</select><br>
						Password:  <input type="password" name="pswWord" value=""><br>
						Confirm Password:  <input type="password" name="pswConf" value=""><br><br>
						
						<input type="submit" value="submit">
					</p>		
				</form>
					<?php
						if(isset($_SESSION["dbUpDate"])){ //database update message/information goes here, or error information. FROM processOrders.php
							echo $_SESSION["dbUpDate"]."<br><br>";//echoed
							unset($_SESSION["dbUpDate"]);//then deleted.
						}
					?>
					<span id="loginWarn"> </span> <!--used for admin.js -->
			</div>
		</div>
	</body>
</html>