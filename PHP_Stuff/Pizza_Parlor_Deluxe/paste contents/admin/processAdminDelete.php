<?php //this is a process page meant to make changes to DB admins users and push user back to deleteAdmin.php with a DB update, or error update.
session_start();

//---------SECURITY STUFF------------
$refer = $_SESSION['addressOne']."/admin/deleteAdmin.php";//allowable referring path
if ($_SERVER['HTTP_REFERER'] != $refer || $_SESSION["loggedIn"] == false ){
	$_SESSION["dbUpDate"] = "Referring Page Incorrect, or insufficient Admin Level, or You tried deleting yourself. processAdminDelete.php error.";//default error when trying to delete self
	$_SESSION["logOnAttempt"] += 1;
	$_SESSION["loggedIn"] = false;
	unset($_SESSION['adminID']);
	unset($_SESSION['adminFName']);
	unset($_SESSION['adminLName']);
	unset($_SESSION['adminAuthLevel']);
	header('Location: '.'LogIn.php');
}//----------------------------------

//---------check for post checkbox data--------
if (!isset($_POST["deleteAdminID"]) || empty($_POST["deleteAdminID"]) ) {//if no data from checkboxes present (or checkboxes werent checked) send user back deleteAdmin.php
	$_SESSION["dbUpDate"] = "Data for _POST not found. Perhaps No Admins were checked. See system admin for help. processAdminDelete.php";
	header('Location: '.'deleteAdmin.php');
}//----------------------------------------

//-------START OF REAL PROGRAM------------------------------------------
else{
	$arrDeleteAdmin = $_POST["deleteAdminID"];//array data from menu's checkboxes
	unset ($_POST["deleteAdminID"]);//no sense in keeping it in post memory now that its used.
	
	require_once("../includes/dbConstants.php");//db stuff
	$sql = "SELECT * FROM admins;";//db query
	$result = mysqli_query($con, $sql) or die( mysqli_error($con));//loads admins table
	//table info: userID login firstName lastName password adminLevel

	if($result){//if query worked
		$row_cnt = $result->num_rows;
		if($row_cnt > 0){// at least one record found in initial db query.
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){//cycles through admins table, one at a time.
				for($i=0; $i < count($arrDeleteAdmin); $i++){//used to cycle through checked checkboxes array from deleteAdmin.php
					if($row["userID"]==$arrDeleteAdmin[$i] && $row["userID"]!=$_SESSION['adminID'] ){//if match between orders table and checkedbox array BUT NOT CURRENT ADMIN. should only matter for auth level 1 admins since auth level 2 cannot get to this page via pathing security permissions.
						$sql2 ="DELETE FROM admins WHERE admins.userID = ".$arrDeleteAdmin[$i].";";//dbquery2
						$result2 = mysqli_query($con, $sql2) or die( mysqli_error($con));
						if($result2){//update successful.success message for deleteAdmin.php
							$_SESSION["dbUpDate"]="Data Base Successfully Updated. Admin has been deleted.";
						}
						else{//update went bad. messages returned back to menu.php
							$_SESSION["dbUpDate"]="Data Base Not Updated Successfully. Error Deleting Admin on processAdminDelete.php. This shouldn't happen.";
							header('Location: '.'deleteAdmin.php');
						}
					}//end of match 'if'
				}//end of cycling 'for' loop
			}//end of while/cycling through admins table loop
			header('Location: '.'deleteAdmin.php');//success!
		}//end of orders found if.
		else{//query successful but 0 results returned.
			$_SESSION["dbUpDate"]="Query successful but 0 results returned. Problem on processAdminDelete.php. This shouldn't happen.";
			header('Location: '.'deleteAdmin.php');
		}
	}
	else{//admins db initial query result execution failure. $result failed.---------
		$_SESSION["dbUpDate"]="Initial Query unsuccessful. Problem on processAdminDelete.php. Contact Admin";
		header('Location: '.'deleteAdmin.php');
	}
}//-------------------END OF PROGRAM---------------------------------------
?>