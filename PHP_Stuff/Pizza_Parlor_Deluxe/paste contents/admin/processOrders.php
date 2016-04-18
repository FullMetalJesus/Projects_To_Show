<?php //this is a process page meant to make changes to DB orders and refer user back to menu.php with a DB update, or error update.
session_start();

//---------SECURITY STUFF------------
$refer = $_SESSION['addressOne']."/admin/menu.php";//allowable referring path
$refer2 = $_SESSION['addressOne']."/admin/processOrders.php";
if ($_SERVER['HTTP_REFERER'] != $refer && $_SERVER['HTTP_REFERER'] != $refer2){
	$_SESSION["loginWarn"] = "Referring Page Incorrect.Please try logging in again. processOrders.php error.";
	$_SESSION["logOnAttempt"] += 1;
	$_SESSION["loggedIn"] = false;
	unset($_SESSION['adminID']);
	unset($_SESSION['adminFName']);
	unset($_SESSION['adminLName']);
	unset($_SESSION['adminAuthLevel']);
	header('Location: '.'LogIn.php');
}
else if($_SESSION["loggedIn"] == false){
	$_SESSION["logOnAttempt"] += 1;
	unset($_SESSION['adminID']);
	unset($_SESSION['adminFName']);
	unset($_SESSION['adminLName']);
	unset($_SESSION['adminAuthLevel']);
	header('Location: '.'LogIn.php');
}
//----------------------------------

//---------check for post checkbox data--------
else if ( !isset($_POST["DeliveryStatus"]) ) {
	$_SESSION["dbUpDate"] = "Data for _POST not set. See system admin for help. processOrders.php";
	header('Location: '.'menu.php');
}
//----------------------------------------

//-------START OF REAL PROGRAM------------------------------------------
else{
	$arrDeliveryStatus = $_POST["DeliveryStatus"];//data from menu's checkboxes
	require_once("../includes/dbConstants.php");//db stuff
	$sql = "SELECT * FROM orders WHERE completed = 'n';";//db query
	$result = mysqli_query($con, $sql) or die( mysqli_error($con));//db result
	//table info: orderID, dateTimePlaced, custID, pizzaDesc, priceSub, tax, priceTotal, completed (value='n' by default)
	
	//orders db query result execution success----------
	if($result){
		$row_cnt = $result->num_rows;
		if($row_cnt > 0){// at least one record found in initial db query.
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){//cycles through orders table, one row at a time where completed='n'
				for($i=0; $i < count($arrDeliveryStatus); $i++){//used to cycle through checked checkboxes array from menu.php
					if($row["orderID"]==$arrDeliveryStatus[$i]){//if match between orders table and checkedbox array.
						$sql2 = "UPDATE orders SET completed = 'y' WHERE orders . orderID = ".$arrDeliveryStatus[$i].";";
						$result2 = mysqli_query($con, $sql2) or die( mysqli_error($con));
						if($result2){//update successful, making succes message for menu.php
							$_SESSION["dbUpDate"]="Data Base Successfully Updated.";
						}
						else{//update went bad. messages returned back to menu.php
							$_SESSION["dbUpDate"]="Data Base Not Updated Successfully. Error on processOrders.php. This shouldn't happen.";
						}
					}//end of if.
				}//end of for loop
			}//end of while/cycling through orders table where completed='n'
			//unset ($_POST["DeliveryStatus"]);//no sense in keeping this around in memory since we already got the data.
			header('Location: '.'menu.php');//return to menu successful!
		}//end of orders found if.
		else{//query successful but 0 results returned.
			$_SESSION["dbUpDate"]="Query successful but 0 results returned. Problem on processOrders.php. This shouldn't happen.";
			header('Location: '.'menu.php');
		}
	}//orders db query result execution failure---------
	else{// $result = failed.
		$_SESSION["dbUpDate"]="Query unsuccessful. Problem on processOrders.php. Contact Admin";
		header('Location: '.'menu.php');
	}
}//-------------------END OF PROGRAM---------------------------------------
?>