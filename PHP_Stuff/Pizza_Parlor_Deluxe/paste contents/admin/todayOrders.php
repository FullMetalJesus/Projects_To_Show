<?php
	session_start();

//-----------security stuff-------------------------
	$refer1 = $_SESSION['addressOne']."/admin/addAdmin.php";//done
	$refer2 = $_SESSION['addressOne']."/admin/deleteAdmin.php";//done
	$refer3 = $_SESSION['addressOne']."/admin/todayOrders.php";//done
	$refer4 = $_SESSION['addressOne']."/admin/allOrders.php";//done
	$refer5 = $_SESSION['addressOne']."/admin/menu.php";//done

	if (($_SERVER['HTTP_REFERER'] != $refer1) && ($_SERVER['HTTP_REFERER'] != $refer2) && ($_SERVER['HTTP_REFERER'] != $refer3) && ($_SERVER['HTTP_REFERER'] != $refer4) && ($_SERVER['HTTP_REFERER'] != $refer5) ){//referring page check
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
	}//--------------end of security stuff-------------------
	
	require_once("../includes/dbConstants.php");//DB connection stuff---------------------
	$sql = "SELECT * FROM orders WHERE dateTimePlaced = CURDATE();";
	$result = mysqli_query($con, $sql) or die( mysqli_error($con) );//end of db stuff-----

	$numberofResults=0;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Password Change</title>
		<meta name="author" content="David Regalado">
		<meta name="keywords" content="final project: Pizza Parlor">
		<meta name="description" content="Admin Menu">
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
				<?php
				if($_SESSION['adminAuthLevel'] == 1){//checks for admin level before admin options appear
					echo '<a href="addAdmin.php" class="orderSum">Add New Admin</a><br>
					<a href="deleteAdmin.php" class="orderSum">Delete Admin</a><br>';
				}
				?>
			</div>
			<div id="main">
				<form name='myForm' id='myForm' action="menu.php" method='post'>
					All Completed Orders Today.
					<table style="border:thin black solid" border="1">
						<tr>
							<th>Date/Time:</th>
							<th>Pizza:</th>
							<th>Customer Info:</th> 
							<!--<th>Order Complete:</th>-->
						</tr>
						<?php
							if ($result->num_rows > 0) {//query successful at least 1 item found.

//note $result order table format: orderID dateTimePlaced custID pizzaDesc priceSub tax priceTotal completed ('n' default) ($row can access these)
								while($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) {//data gotten from current order table
									if($row['completed']=='y'){
										$numberofResults=1;
										$printResult = "<tr><td>" . $row["dateTimePlaced"] . "</td>";
										$printResult = $printResult . "<td>" . $row["pizzaDesc"] . "</td>";
										//set-up below to get data for customer info from customer table(currently only in order table)
										$orderidNumber=$row["orderID"];//used for imprinting check box values
										$custidNumber=$row["custID"];
										$sql2 = 'SELECT * FROM customers WHERE custID = ' . $custidNumber .';';
										$result2 = mysqli_query($con, $sql2) or die( mysqli_error($con));
//note $result2 customer table format: custID custFName custLName custAddress custCity custState custZip custPhone ($row2 can access these)							
										if ($result2) {//customer and order data match!
											while ($row2 = mysqli_fetch_array ($result2,MYSQLI_ASSOC)){//can now access customer data from customer table and output it.
												$printResult = $printResult . "<td>" . $row2["custFName"];
												$printResult = $printResult . " " . $row2["custLName"];
												$printResult = $printResult . " " . $row2["custAddress"];
												$printResult = $printResult . " " . $row2["custCity"];
												$printResult = $printResult . " " . $row2["custState"];
												$printResult = $printResult . " " . $row2["custZip"];
												$printResult = $printResult . " " . $row2["custPhone"]."</td>.<tr/>";
												// deletes checkbox $printResult = $printResult . "<td>" . "<input type='checkbox' name='DeliveryStatus[]' value=$orderidNumber>" . "</td></tr>";// print check box holding orderID number, also while ending td and tr.
												echo $printResult;
											}
										}
										else{//something went wrong horribly wrong..
											$printResult = $printResult . "<td> Something went horribly wrong pulling customer info to match order info. Please notify admin. </td>";
											$printResult = $printResult . "<td>" . "NA" . "</td></tr>";// print default data if No checkbox while ending td and tr.
											echo $printResult;
										}
									}//end if completed=='y'
									else{//no matching results found. with completed and date==today dont need below.
										//echo "<tr><td >No Results1</td><td>No //Results2</td><td>No Results3</td></tr>";
									}
								}// end while loop
								echo "</table>";
							}//end if
							
							else {// no items found, no data in table.
								echo "<tr><td colspan='8'> No Date/Time</td></tr><tr><td colspan='8'>No Pizza</td></tr><tr><td colspan='8'>No Customer Info</td></tr><tr><td colspan='8'>No Orders to Complete.</td></tr></table>";
							}
						?>
				</form>
			</div>
		</div>
	</body>
</html>