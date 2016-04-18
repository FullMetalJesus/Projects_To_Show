<?php
session_start();
//security check could go here: ensuring user came from orders.php, info.php, summary.php to help prevent errors.

//maybe do a if isset $_POST variable check to help prevent errors.

//get priceSub, tax, priceTotal from order.php's hidden form fields. write to corresponding session variables for later use with customers and orders tables in database.
$_SESSION["priceSub"] = floatval($_POST["hiddenPriceSub"]);
$_SESSION["tax"] = floatval($_POST["hiddenTax"]);
$_SESSION["priceTotal"] = floatval($_POST["hiddenPriceTotal"]);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--php enabled using hidden form fields -->
		<title> Pizza Parlor</title>
		<meta charset="utf-8">
		<script type="text/javascript" src="cookies.js"></script>
		<script type="text/javascript" src="jquery-1.7.2.js"></script>
		<script type="text/javascript" src="jquery.validate.js"></script>
		<script type="text/javascript">
			var validForm = false;
			
			SubmittingForm = function () {  
				validForm = true;
				$("#form1").submit();
			}
			
			$(document).ready(function() {//runs form validation
				$("#myForm").validate({ 
					 submitHandler: function (form) {
						if (validForm) {
							newCookie();
							//window.location.assign("pizzaparlor3.html"); old way
							document.getElementById("myForm").submit();
						}
						else {
							SubmittingForm();
						}
					}
				});
			});
			
			
		</script>
		<script type="text/javascript">
			window.onload = function() {
			var strCookie = GetCookie("PizzaDesc");
			document.getElementById("orderinfo").innerHTML = strCookie;
			};
		
			window.onload = function() {
				var strCookie = GetCookie("PizzaDesc");
				document.getElementById("orderinfo").innerHTML = strCookie;
			};
		
			function newCookie(){
				var strCustomerInfo = "Customer Name: " + document.forms[0].elements[0].value + " " + document.forms[0].elements[1].value + " <br> ";
				strCustomerInfo += "Email Address: "+ document.forms[0].elements[2].value+";<br>";
				strCustomerInfo += "Address: "+ document.forms[0].elements[3].value+";<br>";
				if(document.forms[0].elements[4].value!=""){
					strCustomerInfo += "Apt: "+ document.forms[0].elements[4].value+";<br>";
				}
				strCustomerInfo += "City: "+ document.forms[0].elements[5].value+";<br>";
				
				strCustomerInfo += "State: "+ document.forms[0].elements[6].value+";<br>";
				
				strCustomerInfo += "Zip Code: "+ document.forms[0].elements[7].value+";<br>";
				
				strCustomerInfo += "Phone: "+ document.forms[0].elements[8].value + "<br>"; 
				
				SetCookie("OrderInfo",strCustomerInfo); 
			}
		</script>
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
		}
		#rightbar {
			display: block;
			float: right;
			width: 400px;
			height: 800px;
			background-color: blue;
			text-align: left;
		}
		</style>
	</head>
	<body ><!-- populates dynamic area  onload="loadCookie();"-->
		<div id="header">
			<br>
			<br>
			GREETINGS (Form Validation Done with JQuery)
			<br>
		</div>
		<div id="leftbar" >
			<br><br><br><br>
			<a href="../admin/LogIn.php" >Admin Log In</a><br><br><br><br>
			<a href="order.php" >Order Menu</a><br><br><br><br>
		</div>
		<div id="middlebar" >
			<div id="orderinfo" >
				<br>
				<br>
			<!--dhtml here from cookies.-->
				pizza details
				<br>size
				<br>crust
				<br>pizza type
				<br>toppings
				<br>cost details
				<br>subtotal
				<br>tax
				<br>total
				<br>
				<br>
			</div>
			<hr>
			<div id="customerinfo" >
				<br>
				<br>
				<form id="myForm" action="summary.php" method="post">
					Enter Your First Name: <input type="text" id="name" name="name" class="required" size="20" >
					<br>
					<br>
					Enter Your Last Name: <input type="text" id="lastname" name="lastname" class="required" size="20" >
					<br>
					<br>
					Enter Your Email Address: <input type="text" id="email" name="email" size="40" class="required email" >
					<br>
					<br>
					Enter Address: <input type="text" id="address" name="address" size="40" class="required">
					<br>
					<br>
					Enter Apartment (Optional): <input type="text" id="apartment" name="apartment" size="15">
					<br>
					<br>
					City: <input type="text" name="City" id="City" size="20" class="required" >
					<br>
					<br>
					State: <input type="text" name="State" id="State" size="2" class="required">
					<br>
					<br>
					Zip Code: <input type="text" name="Zip" id="Zip" size="5" class="required digits">
					<br>
					<br>
					Phone Number: <input type="text" id="phone" name="phone" size="10" class="required digits" >(continuous xxxxxxxxxx format)
					<br>
					<br>
					<?php
					//creating variables.
						$sizetype=filter_input(INPUT_POST, "sizetype");
						$crusttype=filter_input(INPUT_POST, "crusttype");
						$pizzatype=filter_input(INPUT_POST, "pizzatype");
						$strToppings="";
						$strPrint="";
			
						if($pizzatype=="Specialty"){//Specialty pizza type, a simple select.
							$strToppings=filter_input(INPUT_POST, "specialtyselection");
						}
						else{//Build your own pizza type selected, create toppings list from checkboxes.
								if ( filter_has_var(INPUT_POST, "topping1") ){
									$strToppings.=filter_input(INPUT_POST, "topping1");
								}
								if ( filter_has_var(INPUT_POST, "topping2") ){
									$strToppings.=" ".filter_input(INPUT_POST, "topping2");
								}
								if ( filter_has_var(INPUT_POST, "topping3") ){
									$strToppings.=" ".filter_input(INPUT_POST, "topping3");
								}
								if ( filter_has_var(INPUT_POST, "topping4") ){
									$strToppings.=" ".filter_input(INPUT_POST, "topping4");
								}
								if ( filter_has_var(INPUT_POST, "topping5") ){
									$strToppings.=" ".filter_input(INPUT_POST, "topping5");
								}
								if ( filter_has_var(INPUT_POST, "topping6") ){
									$strToppings.=" ".filter_input(INPUT_POST, "topping6");
								}
						}
//printing hidden fields below.
$strPrint =<<<HERE
<input name="sizetype" type="hidden" value="$sizetype" />
<input name="crusttype" type="hidden" value="$crusttype" />
<input name="pizzatype" type="hidden" value="$pizzatype" />
<input name="strToppings" type="hidden" value="$strToppings" />
HERE;
						print $strPrint;
					?>
					<br>
					<br>
					<input type="submit" value="submit">
				</form>
			</div>
		</div>
		<div id="rightbar">
		<br><br>
		rightbar<br><br>
		nothing here for this page.<br><br>
		</div>
	</body>
</html>