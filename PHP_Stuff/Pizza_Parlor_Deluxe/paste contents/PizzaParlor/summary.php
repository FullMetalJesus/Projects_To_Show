<?php
session_start();
//security check could go here: ensuring user came from orders.php, info.php, summary.php to help prevent errors.

//maybe do a if(isset ($_POST)) variable check to help prevent errors.

$_SESSION["pizzaDesc"]="";//resets value if exists, re-compiles order later this page.
$_SESSION["msgStatus"]="";//used to hold DB query status message.

$strFirstname = $_POST["name"];
$_SESSION["custFName"] = $strFirstname;
$strLastname = $_POST["lastname"];
$_SESSION["custLName"] = $strLastname;
$strEmail = $_POST["email"];//not being sent to DB
$strAddress = $_POST["address"];//Not being sent to db YET...later on in code it will.
$strApartment = "";//getting back to this below. Also not being sent to db YET...later on in code it will.
$strCity = $_POST["City"];
$_SESSION["custCity"] = $strCity;
$strState = $_POST["State"];
$_SESSION["custState"] = $strState;
$strZip = $_POST["Zip"];
$_SESSION["custZip"] = $strZip;
$strphone = $_POST["phone"];
$_SESSION["custPhone"] = $strphone;

$strsizetype = $_POST["sizetype"];
$strcrusttype = $_POST["crusttype"];
$strpizzatype = $_POST["pizzatype"];
$strToppings = $_POST["strToppings"];

$_SESSION["pizzaDesc"] = "Size: ".$strsizetype. " Crust: ".$strcrusttype." Type: ".$strpizzatype." Toppings: ".$strToppings;

if ( filter_has_var(INPUT_POST, "apartment") ){//since apartment was optional, needed to check to see if it was there before assigning a value to $strApartment
	$strApartment = $_POST["apartment"];
	if($strApartment==""){
		$strApartment = "N/A";
	}
}
$_SESSION["custAddress"] = $strAddress." ".$strApartment;//will be saved and stored to DB.
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Order Information</title>
<style>
		*{
			margin: 0px;
			padding: 0px;
		}
		body {
			width: 1200px;
			height: 1000px;
			font-family: Arial, sans-serif, Helvetica, "Times New Roman";
			font-size: 14px;
			text-align: center;
		}
		#header {
			height: 200px;
			width: 100%;
			display: block;
			background-color: grey;
		}
		#leftbar {
			display: block;
			float: left;
			width: 100px;
			height: 800px;
			background-color: red;
		}
		#middlebar {
			display: block;
			float: left;
			width: 700px;
			height: 800;
			background-color: white;
			font-size: 14px;
		}
		#rightbar {
			display: block;
			float: right;
			width: 400px;
			height: 800px;
			background-color: blue;
			text-align: left;
		}
		span {
		font-size: 50px;
		}
		</style>
<script>
	var minutes= 29;
	var seconds= 59;
	window.onload = function(){
		setInterval(function(){
			if( (seconds >= 10) && (minutes >= 10) ) {//prints clock when both values are greater than or equal to 10(normal).
				document.getElementById("countdownTimer").innerHTML =  minutes+":"+seconds;
			}
		
			else if( (seconds < 10) && (seconds > -1) && (minutes >= 10) ){//prints clock when seconds are between (including) 0 and 9(not normal), and minutes is greater than or equal to 10(normal).
			document.getElementById("countdownTimer").innerHTML = minutes+":"+"0"+seconds;
			}
		
			else if((seconds < 10) && (seconds > -1) && (minutes < 10) && (minutes > -1) ){//prints clock when both values are between (including) 0 and 9 (not normal).
				document.getElementById("countdownTimer").innerHTML = "0"+minutes+":"+"0"+seconds;
			}
		
			seconds--;
			if(seconds == -1){
				minutes--;
				seconds = 59;// resets seconds once minutes has decremented once.
				if(minutes == 0){
					minutes = 0;//just to be sure minutes doesn't go negative.
					if(minutes==0 && seconds==0){
						minutes =0;
						seconds=0;//just to be sure time doesn't go negative.
					}
				}
			}
        },1000);
		//loading cookie here.
	}  
</script>
<!-- Added cookies.js -->
<script type="text/javascript" src="cookies.js"></script>
</head>
<body>
	<div id="header">
			<br>
			<br>
			GREETINGS
			<br>
	</div>
	<div id="leftbar" >
			<br><br><br><br>
			<a href="../admin/LogIn.php" >Admin Log In</a><br><br><br><br>
			<a href="order.php" >Order Menu</a><br><br><br><br>
	</div>
	<div id="middlebar">
		<hr>
		<div id="timerContainer">
			You're Pizza will be ready in <span id="countdownTimer">30:00</span> minutes.(Java Script Clock)
		</div>
		<div id="orderInfo" >
			<br>
			Cookie PizzaDesc info displayed below using Java Script:
			<br>
			<!-- dhtml here from cookies.-->	
			<script type="text/javascript">				
				document.write(GetCookie("PizzaDesc"));
			</script>
			<br>
			<br>
			<hr>
			<br>
			Cookie OrderInfo info displayed below using Java Script:
			<br>
			<script type="text/javascript">				
				document.write(GetCookie("OrderInfo"));
			</script>
			<br>
			<hr>
			<br>
			PHP customer/order variables displayed below using PHP:
			<br>
			<br>
<?php
$strPrint =<<<HERE
Customers First Name: $strFirstname <br>
Customers Last Name: $strLastname <br>
Customers Email: $strEmail <br>
Customers Street Address: $strAddress<br>
Customers Apartment: $strApartment <br>
Customers City: $strCity <br>
Customers State: $strState <br>
Customers Zip: $strZip <br>
Customers Phone Number: $strphone <br>
Customers Pizza Size: $strsizetype <br>
Customers Crust: $strcrusttype <br>
Customers Type of Pizza: $strpizzatype <br>
Customers Toppings on Pizza: $strToppings <br>
HERE;
	print $strPrint;
	
// ------------------Database initial stuff------------------------
	require_once("../includes/dbConstants.php");
	$customerfound=0;
	$orderandcustomer=1;//indicator if new order and new customer successfully processed.
	$sql = "SELECT * FROM customers;";
	$result = mysqli_query($con, $sql) or die( mysqli_error($con) );				
	$sql2="";
	$result2="";
	$sql3="";//may or may not be used
	$result3="";//may or may not be used
	$sql4="";//may or may not be used
	$result4="";//may or may not be used
	$newcustomerID=1;//may or may not be used. defaults to default customer otherwise
//-------------IF INITIAL QUERY SUCCESSFULL---------------		
	if ($result->num_rows > 0) {//initial query successful and results found on CUSTOMERS TABLE.
		
//---------------check for and try to process new order with EXISTING CUSTOMER.
		while($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) {//loop through table
//NOTE customers table: custID, custFName, custLName, custAddress, custCity, custState, custZip, custPhone.

			//if current customer data matches existing customer data
			if( ($row['custPhone']==$_SESSION["custPhone"] ) && ($row['custFName']==$_SESSION["custFName"]) && ($row['custLName']==$_SESSION["custLName"]) ){
//NOTE orders table: orderID, dateTimePlaced, custID, pizzaDesc, priceSub, tax, priceTotal, completed
				$customerfound=1;//used for the next section: new customer, new order.
				
				//setup sql statement to insert ORDER DATA INTO ORDERS TABLE using existing CUSTOMER ID.
				$sql2 = "INSERT INTO orders (dateTimePlaced, custID, pizzaDesc, priceSub, tax, priceTotal, completed) VALUES (CURDATE(), ".$row['custID'].", '".$_SESSION['pizzaDesc']."', ".$_SESSION['priceSub'].", ".$_SESSION['tax'].", ".$_SESSION['priceTotal'].", 'n');";
				$result2 = mysqli_query($con, $sql2) or die( mysqli_error($con) );
				//add record to orders table: (generated Curdate), custID, pizzaDesc, priceSub, tax, priceTotal, completed ='n'
				
				if ($result2){//new order processed for existing customer
						$_SESSION["msgStatus"]="Success: new order processed for existing customer.";
						$orderandcustomer=1;
				}
				else{//Failed to process new order for existing customer.
					$_SESSION["msgStatus"]="Failure: new order not processed for existing customer. summary.php error";
					header('Location: '.'order.php');
				}
			}
		}//no existing customer match found.
//--------------end of query attempt to use existing customer info to place the new order.
		
//-----------------------proceed processing new customer, then new order.
		if($customerfound==0){
			//process new customer first.
			$sql2 = "INSERT INTO customers (custFName, custLName, custAddress, custCity, custState, custZip, custPhone) VALUES ('".$_SESSION['custFName']."', '".$_SESSION['custLName']."', '".$_SESSION['custAddress']."', '".$_SESSION['custCity']."', '".$_SESSION['custState']."', '".$_SESSION['custZip']."', '".$_SESSION['custPhone'] ."');";
			$result2 = mysqli_query($con, $sql2) or die( mysqli_error($con) );
			
			if($result2){//if new customer successfully processed.
				//get new customer custID
				$sql3="SELECT * FROM customers ORDER BY custID DESC LIMIT 1;";
				$result3 = mysqli_query($con, $sql3) or die( mysqli_error($con) );
				if($result3){//query attempting to get custID of most recent customer
					while($row3 = mysqli_fetch_array ($result3, MYSQLI_ASSOC)) {
						$newcustomerID=$row3['custID'];
					}
					//process new order using new customer's custID.
					$sql4="INSERT INTO orders (dateTimePlaced, custID, pizzaDesc, priceSub, tax, priceTotal, completed) VALUES (CURDATE(), ".$newcustomerID.", '".$_SESSION['pizzaDesc']."', ".$_SESSION['priceSub'].", ".$_SESSION['tax'].", ".$_SESSION['priceTotal'].", 'n');";
					$result4 = mysqli_query($con, $sql4) or die( mysqli_error($con) );
					if($result4){//success. new order added using new customers custID
						$_SESSION["msgStatus"]="Success: New Customer and New order added.";
					}
					else{//new order failed to process using new customers custID
						$_SESSION["msgStatus"]="Failure: new customer processed,BUT either newcustomerID was blank and/or the processing of the new order from new customer failed. summary.php error";
						header('Location: '.'order.php');
					}
				}
				else{//New customer added, but query attempting to get new customers custID failed.
					$_SESSION["msgStatus"]="Customer added, but query attempting to get most recent custID failed. summary.php";
					header('Location: '.'order.php');
				}
			}
			else{//new customer not successfully processed.error.
				$_SESSION["msgStatus"]="new Customer not added. summary.php";
				header('Location: '.'order.php');
			}
		}//end of new customer + new order processing attempt
	}//end of initial query if
//-------------initial query failed------------------
	else{//initial query failed, or 0 results listed from customers table.
		$_SESSION["msgStatus"]="Initial query failed, or customers table empty. summary.php";
		header('Location: '.'order.php');
	}
?>
		</div>
	</div>
	<div id="rightbar">
		<br>
		<br>
		RightBar: Nothing here except DB query status messages
		<br>
		<br>
		<?php
		if(isset($_SESSION["msgStatus"])){
			echo $_SESSION["msgStatus"];
			unset($_SESSION["msgStatus"]);
		}
		?>
		<br><br>
	</div>
</body>
</html>