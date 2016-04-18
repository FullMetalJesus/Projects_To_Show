<?php
session_start();
$_SESSION['addressOne']="sql309.podserver.info";
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
		<?php	   
		$blnShowForm = true;
		/*  session logging enforcer blocked for testing purposes. Also it could end up easily compromising the application should no developer be available to undo the php check here.
		
		// check to see if this is the first time the user has attempted to log into the administrative site, if so, the session variable will not exist, so it needs to be created.
		// use the isset() method to determine if the variable exists
		if (!isset($_SESSION["logOnAttempt"])) {
		// create a session variable to determine the number of log in attempts
			$_SESSION["logOnAttempt"] = 0;
			$blnShowForm = true;
		}
		// check to see if the there have been 10 or more log in attempts
		elseif ($_SESSION["logOnAttempt"] >= 10){
			$_SESSION["loginWarn"] = "There is a problem with the log in capabilities[10].  Contact the administrator of this site for access.";
			// to help secure your site, you would acquire the IP addresses of the current user and write it to a table in your database to block this IP Address. perhaps send user to a processing page.
			$blnShowForm = false;
		}
		// check to see if there have been 3 or more log in attempts
		elseif ($_SESSION["logOnAttempt"] >= 3) {
			$_SESSION["loginWarn"] = "There is a problem with your credentials[3]. Contact the administrator of this site for access.";
			// to help secure your site, you would remove the log in form and have the user call the administrator of the site to (disable this portion of the form check?) Perhaps send user to a processing page.
			$blnShowForm = false;
		}
		
		************************************************************/
		?>
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
				<a href="LogIn.php" class="orderSum">Log In</a><br>
				<a href="../PizzaParlor/order.php" class="orderSum" >Place Order</a><br>
				<?php
				if(isset($_SESSION['loggedIn'])){//stay logged in with access to admin menu if already logged in.
					if($_SESSION['loggedIn'] == 'true'){//checks for admin level before admin options appear
						echo '<br><a href="menu.php" class="orderSum">Admin Menu</a><br>';
						echo '<br><a href="LogOut.php" class="orderSum">LogOut</a><br>';//option to log out current user. No security checks necessary
					}
				}	
				?>
			</div>
			<?php 
				if ($blnShowForm == true){
			?>
			<form method="post" action="ProcessPage.php" onsubmit="return chkForm(0)">
				<div id="main">
					<p>
						<h4>NOTE: YOU MUST LOG OUT, else you will remain logged in. (Or until you try to log in again unsuccessfully, perhaps to a different account. Or close the browser.</h4>
						Please enter your administrator log in:<br>
						User Name:default Password: Nothing!1  (for a fresh log in experience)<br>
						Else use(respectively):  David  and P13a5e!84<br><br>
						<br><br>
						User name: <input type="text" name="txtUser" class="input" value=""><br>
						Password: &nbsp;&nbsp;<input type="password" name="pswWord" class="input"><br><br>
						<input type="submit" value="Log In">
					</p>		
			<?php
			}
			?>
					<span id="loginWarn">
					<?php
						// Session variable to display login in warning
						if (isset($_SESSION["loginWarn"])){
							echo $_SESSION["loginWarn"];
							unset($_SESSION["loginWarn"]);//clears login warn for new info to be held.
						}
					?>
					</span>
				</div>
			</form>
		</div>
	</body>
</html>