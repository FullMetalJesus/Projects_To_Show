<?php
session_start();
//Need to access a session variable if there's an error on summary, and display to user.

?>
<!DOCTYPE html>
<html>
	<head>
		<title> Pizza Parlor</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="pizzaParlor.css">
		<script type="text/javascript" src="cookies.js"></script>
		<script type="text/javascript">
		<!--
		var hiddenPriceSub = 0.00; //floats used for hidden field
		var hiddenTax = 0.00;
		var hiddenPriceTotal = 0.00;
		
		function theVanishing(target1, target2) {//makes the specialty div or(but not both) the build your own div appear. Next, it calls the appropriate build/specialty pizza functions to re-populate the dynamic field.
				
				if(document.forms[0].pizzatype[0].selected) {//specialty selected
						document.getElementById(target1).style.display = 'block'; //shows specialty section
						document.getElementById(target2).style.display = 'none'; //hides build section
						specialtyForm();//re-populates dyanmic field based on selection
				}
				else { //build selected
					document.getElementById(target1).style.display = 'none';//hides specialty section
					document.getElementById(target2).style.display = 'block'; //shows build section
					buildToppings(); //re-populates dynamic field based on selection
				}
		}
		
		function specialtyForm(){// advanced version of order form.  redisplays all the selected values in the dynamic field. and writes the cookie.
			var strSize = "";
			var intSizeLen = document.forms[0].sizetype.length;
			
			var strCrust = "";
			var intCrustLen = document.forms[0].crusttype.length;
			
			var strType = "";
			var intTypeLen = document.forms[0].pizzatype.length;
			
			var strToppings = "";
			var intToppingsLen = document.forms[0].specialtyselection.length;
			
			var fltPizzaSub = 0;
			var fltTax= 1.08;
			var fltGrandTotal =0.00;
			
			
			for (var i = 0; i < intSizeLen; i++){
				if (document.forms[0].sizetype[i].selected){					
					strSize = document.forms[0].sizetype[i].value;
				}
			}
			
			for (var i = 0; i < intCrustLen; i++){
				if (document.forms[0].crusttype[i].selected){					
					strCrust = document.forms[0].crusttype[i].value;
				}
			}
			
			for (var i = 0; i < intTypeLen; i++){
				if (document.forms[0].pizzatype[i].selected){					
					strType = document.forms[0].pizzatype[i].value;
				}
			}
			
			for (var i = 0; i < intToppingsLen; i++){
				if (document.forms[0].specialtyselection[i].selected){					
					strToppings = document.forms[0].specialtyselection[i].value;
				}
			}
			
			switch (strSize){
				case "small":
					fltPizzaSub += 4;
					break;
				case "medium":
					fltPizzaSub += 5;
					break;
				case "large":
					fltPizzaSub += 6;
					break;
			}
			
			switch (strCrust){
				case "thin":
					fltPizzaSub += 1;
					break;
				case "normal":
					fltPizzaSub += 2;
					break;
				case "deep dish":
					fltPizzaSub += 3;
					break;
			}
			
			switch (strType){
				case "Specialty":
					fltPizzaSub += 1;
					break;
				case "Build Your Own":
					fltPizzaSub += 2;
					break;
				default:
					fltPizzaSub += 1;
					break;
			}
			
			switch (strToppings){
				case "Veggie Lovers: mushrooms, black olives, green peppers, tomatoes, green peppers, onions":
					fltPizzaSub += 1;
					break;
				case "Hawaiian: pineapple, peppers, green peppers, pepperoni, ham, black olives":
					fltPizzaSub += 2;
					break;
				case "Meat Lovers: ham, bacon, pepperoni, sausage, meatballs, steak":
					fltPizzaSub += 3;
					break;
			}
			//priceSub: fltPizzaSub. write it to a hidden field for post to pick up with php
			hiddenPriceSub = fltPizzaSub;//---------------
			//tax: (fltPizzaSub * fltTax) write it to a hidden field for post to pick up with php
			hiddenTax = (fltPizzaSub * .08);
			hiddenTax = hiddenTax.toFixed(2);//---------
			fltGrandTotal = (fltPizzaSub* fltTax);
			fltGrandTotal=fltGrandTotal.toFixed(2);
			//priceTotal: fltGrandTotal write it to a hidden field for post to pick up with php
			hiddenPriceTotal = fltGrandTotal;//-------------
			
			//writing to hidden form field----------------
			document.getElementById("leftbar").innerHTML ="<br><br><br><br><a href='../admin/LogIn.php' >Admin Log In</a><br><br><br><br><a href='order.php' >Order Menu</a><br><br><br><br><input name='hiddenPriceSub' type='hidden' value="+hiddenPriceSub+"/><br><input name='hiddenTax' type='hidden' value="+hiddenTax+"/><br><input name='hiddenPriceTotal' type='hidden' value="+hiddenPriceTotal+"/>";
			
			document.getElementById("dynamicfield").innerHTML = "Pizza Size: "+strSize + ";<br>Crust Type: " + strCrust + ";<br>Pizza Type: " + strType + ";<br>Toppings: " +strToppings+";<br> SubTotal: " +fltPizzaSub+";<br>TaxRate: " +fltTax+";<br>GrandTotal: " + fltGrandTotal;
			
			SetCookie("PizzaDesc", document.getElementById("dynamicfield").innerHTML);

		}
		function buildToppings(){// altered version of specialtyForm(based on orderform).  redisplays all the selected values, including the checkboxed values in the dynamic field.(but not the selectedspecialty selected values) and writes the cookie.
			var strSize = "";
			var intSizeLen = document.forms[0].sizetype.length;
			
			var strCrust = "";
			var intCrustLen = document.forms[0].crusttype.length;
			
			var strType = "";
			var intTypeLen = document.forms[0].pizzatype.length;
			
			var strToppings = "";
			
			var fltPizzaSub = 0;
			var fltTax= 1.08;
			var fltGrandTotal =0.00;
			
			
			for (var i = 0; i < intSizeLen; i++){
				if (document.forms[0].sizetype[i].selected){					
					strSize = document.forms[0].sizetype[i].value;
				}
			}
			
			for (var i = 0; i < intCrustLen; i++){
				if (document.forms[0].crusttype[i].selected){					
					strCrust = document.forms[0].crusttype[i].value;
				}
			}
			
			for (var i = 0; i < intTypeLen; i++){
				if (document.forms[0].pizzatype[i].selected){					
					strType = document.forms[0].pizzatype[i].value;
				}
			}
			
			if(document.getElementById('topping1').checked==true){
				strToppings += document.forms[0].topping1.value+" ";
				fltPizzaSub += .25;
			}
			if(document.getElementById('topping2').checked==true){
				strToppings += document.forms[0].topping2.value+" ";
				fltPizzaSub += .25;
			}
			if(document.getElementById('topping3').checked==true){
				strToppings += document.forms[0].topping3.value+" ";
				fltPizzaSub += .25;
			}
			if(document.getElementById('topping4').checked==true){
				strToppings += document.forms[0].topping4.value+" ";
				fltPizzaSub += .25;
			}
			if(document.getElementById('topping5').checked==true){
				strToppings += document.forms[0].topping5.value+" ";
				fltPizzaSub += .25;
			}
			if(document.getElementById('topping6').checked==true){
				strToppings += document.forms[0].topping6.value+" ";
				fltPizzaSub += .25;
			}
			
			
			switch (strSize){
				case "small":
					fltPizzaSub += 4;
					break;
				case "medium":
					fltPizzaSub += 5;
					break;
				case "large":
					fltPizzaSub += 6;
					break;
			}
			
			switch (strCrust){
				case "thin":
					fltPizzaSub += 1;
					break;
				case "normal":
					fltPizzaSub += 2;
					break;
				case "deep dish":
					fltPizzaSub += 3;
					break;
			}
			
			switch (strType){
				case "Specialty":
					fltPizzaSub += 1;
					break;
				case "Build Your Own":
					fltPizzaSub += 2;
					break;
			}
			//priceSub: fltPizzaSub. write it to a hidden field for post to pick up with php
			hiddenPriceSub = fltPizzaSub;//---------------
			//tax: (fltPizzaSub * fltTax) write it to a hidden field for post to pick up with php
			hiddenTax = (fltPizzaSub * .08);
			hiddenTax = hiddenTax.toFixed(2);//---------
			fltGrandTotal = (fltPizzaSub * fltTax);
			fltGrandTotal=fltGrandTotal.toFixed(2);
			//priceTotal: fltGrandTotal write it to a hidden field for post to pick up with php
			hiddenPriceTotal = fltGrandTotal;//-------------
			
			//writing to hidden form field----------------
			document.getElementById("leftbar").innerHTML ="<br><br><br><br><a href='../admin/LogIn.php' >Admin Log In</a><br><br><br><br><a href='order.php' >Order Menu</a><br><br><br><br><input name='hiddenPriceSub' type='hidden' value="+hiddenPriceSub+"/><br><input name='hiddenTax' type='hidden' value="+hiddenTax+"/><br><input name='hiddenPriceTotal' type='hidden' value="+hiddenPriceTotal+"/>";
			
			document.getElementById("dynamicfield").innerHTML = "Pizza Size: "+strSize + ";<br>Crust Type: " + strCrust + ";<br>Pizza Type: " + strType + ";<br>Toppings: " +strToppings+";<br> SubTotal: " +hiddenPriceSub+";<br>TaxRate: " +fltTax+";<br>GrandTotal: " + hiddenPriceTotal;
			
			SetCookie("PizzaDesc", document.getElementById("dynamicfield").innerHTML);
		}
		function nextpagePlease(){
			theVanishing('specialtypizza', 'buildyourownpizza');
			if(confirm("Would you like to continue to the next page to complete your order?")==true){
				//window.location.assign("pizzaparlor2.html"); old way
				theVanishing('specialtypizza', 'buildyourownpizza');
				document.getElementById("form0").submit();
			}
			else{
				theVanishing('specialtypizza', 'buildyourownpizza');
				alert("Re-Check your order and proceed when ready");
			}
		}
		-->
		</script>
	</head>
	<body>
		<form   name="form0" id="form0" action="info.php" method="post">
			<div id="header">
				<br>
				<br>
				GREETINGS
				<br>
				<br>
			</div>
			<div id="leftbar">
				<br><br><br><br>
				<a href="../admin/LogIn.php" >Admin Log In</a><br><br><br><br>
				<a href="order.php" >Order Menu</a><br><br><br><br>
			</div>
			<div id="middlebar">
				<div>
					<br>
					<br>
					Pick your pizza size: 
					<select name="sizetype" id="sizetype"  onchange="theVanishing('specialtypizza', 'buildyourownpizza');"><!--small defaulted to 'selected' for functionality purposes. -->
						<option selected="selected" value="small">small</option>
						<option value="medium">medium</option>
						<option value="large">large</option>
					</select>
					<br>
					<br>
					pick your crust type
					<select name="crusttype" id="crusttype"  onchange="theVanishing('specialtypizza', 'buildyourownpizza');"><!--thin defaulted to 'selected' for functionality purposes. -->
						<option selected="selected" value="thin">thin</option>
						<option value="normal">normal</option>
						<option value="deep dish">deep dish</option>
					</select>
					<br>
					<br>
					Build your own or get a specialty pizza:
					<select name="pizzatype" id="pizzatype"  onchange="theVanishing('specialtypizza', 'buildyourownpizza');" ><!--Specialty defaulted to 'selected' for functionality purposes. -->
						<option selected="selected" value="Specialty">Specialty</option>
						<option value="Build Your Own">Build your own</option>
					</select>
				<br>
				<br>
				<br>
				<hr>
			</div>
			<div id="specialtypizza"  class="vanish1" style="display:block">
				<select name="specialtyselection" id="specialtyselection"  onchange="specialtyForm()"><!--veggie lovers defaulted to 'selected' for functionality purposes. -->
					<option selected="selected" value="Veggie Lovers: mushrooms, black olives, green peppers, tomatoes, green peppers, onions">Veggie Lovers</option>
					<option value="Hawaiian: pineapple, peppers, green peppers, pepperoni, ham, black olives">Hawaiian</option>
					<option value="Meat Lovers: ham, bacon, pepperoni, sausage, meatballs, steak">Meat Lovers</option>
				</select>
				<br>
				<br>
				Hawaiian: (pineapple, peppers, green peppers, pepperoni, ham, black olives)
				<br>
				<br>
				Veggie Lovers: (mushrooms, black olives, green peppers, tomatoes, green peppers, onions)
				<br>
				<br>
				Meat Lovers: (ham, bacon, pepperoni, sausage, meatballs, steak)
				<br>
				<br>
				<br>
			</div>
			<div id="buildyourownpizza" class="vanish2"  style="display:none"><!--all defaulted to 'checked' for functionality purposes. -->
				Build your own Pizza
				<br>
				<br>
				<input type="checkbox" name="topping1" id="topping1" value="mushrooms" checked="checked" onclick = "theVanishing('specialtypizza', 'buildyourownpizza');">mushrooms
				<br>
				<br>
				<input type="checkbox" name="topping2" id="topping2" value="black olives" checked="checked" onclick ="theVanishing('specialtypizza', 'buildyourownpizza');">black olives
				<br>
				<br>
				<input type="checkbox" name="topping3" id="topping3" value="green peppers" checked="checked" onclick ="theVanishing('specialtypizza', 'buildyourownpizza');">green peppers
				<br>
				<br>
				<input type="checkbox" name="topping4" id="topping4" value="pepperoni" checked="checked" onclick ="theVanishing('specialtypizza', 'buildyourownpizza');">pepperoni
				<br>
				<br>
				<input type="checkbox" name="topping5" id="topping5" value="sausage" checked="checked" onclick = "theVanishing('specialtypizza', 'buildyourownpizza');">sausage
				<br>
				<br>
				<input type="checkbox" name="topping6" id="topping6" value="pineapple" checked="checked" onclick ="theVanishing('specialtypizza', 'buildyourownpizza');">pineapple
				<br>
				<br>
			</div>
			<div id="submitbuttonfield">
				<br>
				<br>
				<input type="button" value="submit my order" onclick="nextpagePlease();">
				<br>
				<br>
			</div>
			</div>
			<div id ="dynamicfield">
			<br><br>
			completely dynamic html here. (this will go away when making selections)
			<br><br>
			</div>
		</form>
			<?php
			if(isset($_SESSION["msgStatus"])){
				echo $_SESSION["msgStatus"];
				unset($_SESSION["msgStatus"]);
			}
			?>
	</body>
</html>