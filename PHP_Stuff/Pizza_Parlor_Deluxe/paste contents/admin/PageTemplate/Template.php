<?php
session_start();
//stuffhere
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
				<img src="../graphics/pizza.jpeg" width="238" height="120" alt="" id="logo">
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
				<a href="../home.html" class="orderSum">Home</a><br>
				<a href="../contact.html" class="orderSum">Contact Us</a><br>
				<a href="../order.html" class="orderSum">Order Now</a>
			</div>
			<form method="post" action="ProcessPage.php" onsubmit="return chkForm(0)">
				<div id="main">
					<p>
						Please enter your administrator log in:<br><br>
						User name: <input type="text" name="txtUser" class="input" value=""><br>
						Password: &nbsp;&nbsp;<input type="password" name="pswWord" class="input"><br><br>
						<input type="submit" value="Log in">
					</p>		
					<span id="loginWarn">
					<?php
						// Session variable to display login in warning
						if (isset($_SESSION["loginWarn"])){
							echo $_SESSION["loginWarn"];
						}
					?>
					</span>
				</div>
			</form>
		</div>
	</body>
</html>