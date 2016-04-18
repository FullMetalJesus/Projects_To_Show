<?php
	session_start();

//-----------security stuff-------------------------
	$refer1 = $_SESSION['addressOne']."/admin/addAdmin.php";//done
	$refer2 = $_SESSION['addressOne']."/admin/deleteAdmin.php";//done.
	$refer3 = $_SESSION['addressOne']."/admin/todayOrders.php";//done.
	$refer4 = $_SESSION['addressOne']."/admin/allOrders.php";//done.
	$refer5 = $_SESSION['addressOne']."/admin/menu.php";//done.
	$refer6 = $_SESSION['addressOne']."/admin/processAdminDelete.php";//done.
	
	if (($_SERVER['HTTP_REFERER'] != $refer1) && ($_SERVER['HTTP_REFERER'] != $refer2) && ($_SERVER['HTTP_REFERER'] != $refer3) && ($_SERVER['HTTP_REFERER'] != $refer4) && ($_SERVER['HTTP_REFERER'] != $refer5) && ($_SERVER['HTTP_REFERER'] != $refer6) || ($_SESSION["loggedIn"] == false) ){//referring page check
		$_SESSION["loginWarn"] = "Referring Page Incorrect or insufficient permissions.Please try logging in again. deleteAdmin.php error.";
		$_SESSION["logOnAttempt"] += 1;
		unset($_SESSION['adminID']);
		unset($_SESSION['adminFName']);
		unset($_SESSION['adminLName']);
		unset($_SESSION['adminAuthLevel']);
		header('Location: '.'LogIn.php');
	}
//--------------end of security stuff-------------------

//-----------sql connection stuff------------
	require_once("../includes/dbConstants.php");
	$sql = "SELECT * FROM admins;";
	$result = mysqli_query($con, $sql) or die( mysqli_error($con) );
	$printButton=0;//variable used to determine if 'submit' button will appear, 0 for no, 1 for yes.
//--------------------------------------------
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
				<a href="todayOrders.php" class="orderSum">Complete(Today)</a><br>
				<a href="allOrders.php" class="orderSum">Complete(History)</a><br>
				<a href="menu.php" class="orderSum">Admin Menu</a><br>
				<a href="addAdmin.php" class="orderSum">Add New Admin</a><br>
				<a href="deleteAdmin.php" class="orderSum">Delete Admin</a><br>
			</div>
			<form method="post" action="processAdminDelete.php">
				<div id="main">
					NOTE: YOU CANNOT DELETE YOURSELF.
					<table style="border:thin black solid" border="1">
						<tr>
							<th>userid</th>
							<th>login</th>
							<th>firstname</th>
							<th>lastname</th> 
							<!--<th>password</th>-->
							<th>adminlevel</th>
							<th>Delete</th>
						</tr>
						<?php
							if ($result->num_rows > 0) {
								$printButton =1;
								while($row = $result->fetch_assoc()) {
// admin table format: userID , login,firstName,lastName,password,adminLevel
									$printResult = "<tr><td>" . $row["userID"] . "</td>";
									$printResult = $printResult . "<td>" . $row["login"] ."</td>";
									$printResult = $printResult . "<td>" . $row["firstName"] ."</td>";
									$printResult = $printResult . "<td>" . $row["lastName"] . "</td>";
									//$printResult = $printResult . "<td>" . $row["password"] . "</td>";
									$printResult = $printResult . "<td>" . $row["adminLevel"] . "</td>";
									$deleteAdminID = $row['userID'];//gets adminID number
									$printResult = $printResult . "<td>" . "<input type='checkbox' name='deleteAdminID[]' value=$deleteAdminID>" . "</td></tr>";
									echo $printResult;
								}
							}
							else {
								echo "<tr><td colspan='8'>0 results. I feel bad.No Data In Table. </td></tr>";
							}
						?>
					</table>
					<?php
					if($printButton == 1){//print submit button if data exists in table. should send user to processOrders.php
						print "<br><br><input type='submit'><br><br>";
					}
					?>
					<?php
						if(isset($_SESSION["dbUpDate"])){ //database update message/information goes here, or error information. FROM processAdminDelete.php
							echo $_SESSION["dbUpDate"]."<br><br>";//echoed
							unset($_SESSION["dbUpDate"]);//then deleted.
						}
					?>
				</div>
			</form>

		</div>
	</body>
</html>