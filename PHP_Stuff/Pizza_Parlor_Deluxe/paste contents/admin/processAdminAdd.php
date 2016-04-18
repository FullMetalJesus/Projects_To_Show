<?php //process page meant to add admin to db and send user back to addAdmin.php
session_start(); 

//----------security stuff----------------------------------
$refer1 = $_SESSION['addressOne']."/admin/addAdmin.php";

if ($_SERVER['HTTP_REFERER'] != $refer1){ // check to see if the referring page is correct, if not, send the user back to the log in page
		$_SESSION["loginWarn"] = "Referring Page Incorrect.Please try logging in. ProcessAdminAdd error.";
		$_SESSION["logOnAttempt"] += 1;
		$_SESSION["loggedIn"] = false;
		unset($_SESSION['adminID']);
		unset($_SESSION['adminFName']);
		unset($_SESSION['adminLName']);
		unset($_SESSION['adminAuthLevel']);
		header('Location: '.'LogIn.php');
}
if($_SESSION["loggedIn"] == false){ //authorization level check
		$_SESSION["loginWarn"] = "You do not have sufficient permissions to add Admins. processAdminAdd.php";
		$_SESSION["logOnAttempt"] += 1;
		$_SESSION["loggedIn"] = false;
		unset($_SESSION['adminID']);
		unset($_SESSION['adminFName']);
		unset($_SESSION['adminLName']);
		unset($_SESSION['adminAuthLevel']);
		header('Location: '.'LogIn.php');
}
//------------------------------------------------

//-------Variable  check---------------------------
 // check to see if all the necessary vars have been set and to make sure password and password confirmation match. if not, send the user back to the addAdmin page
if ( !isset($_POST['login']) || !isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['adminLevel']) || !isset($_POST['pswWord']) || !isset($_POST['pswConf']) || ($_POST['pswWord'] != $_POST['pswConf']) ){
    $_SESSION["dbUpDate"] = "Necessary variables are not set or passwords do not match. Please try again.processAdminAdd error.";
	header('Location: '.'addAdmin.php');
}
//-------------------------------------------------

//-------------REAL PROGRAM---------------
else { //permissions met, variables and data received from addAdmin.php
    require_once("../includes/dbConstants.php");
	
    $login = $_POST['login'];
	$firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
	$adminLevel = $_POST['adminLevel'];
	$pswWord = $_POST['pswWord'];
	$pswConf = $_POST['pswConf'];
	
	//used for storing DB stored log ins
	$DBstoredlogin="";
	
	// used for encrypting the user's password, clear hash if exists
    $hashPass = "";

    // start SQL statement
	$sql2="";
	$result2="";
	$sql="SELECT * FROM admins;";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	if ($result) { // place result in associative array and capture the returned data [result cannot be 0 by default,else you couldnt be here, so no need to check for >0 results]
		while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) { 
			$DBstoredlogin = $row["login"];
			if($DBstoredlogin == $login){ //if there is a previous existing login that matches the one desired.
				$_SESSION["dbUpDate"]="Invalid log in. please try another one. processAdminAdd.php";
				header('Location: '."addAdmin.php");
			}
		}//end of while cycling through db records.
		
		//reg expression to test passwords complexity requirement
		$re = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&*()]).{8,}/";
		if (preg_match($re, $pswWord)) { // all password complexity requirements have been met
			
			$hashPass = hash('sha256', $pswWord);//hash desired password
			
			$sql2='INSERT INTO admins (login, firstName, lastName, password, adminLevel) VALUES ("'.$login.'", "'.$firstName.'", "'.$lastName.'", "'.$hashPass.'", '.$adminLevel.');';
			
			$result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));//appends new admin data to database
			
			if($result2){//db update successful
				$_SESSION["dbUpDate"]="Database Successfully updated with new Administrator. processAdminAdd.php";
				header('Location: '."addAdmin.php");
			}
			else{//db update with new admin data not successful
				$_SESSION["dbUpDate"]="Database failed to add new Administrator. Contact system Admin.  processAdminAdd.php";
				header('Location: '."addAdmin.php");
			}
		}
		else {// new password does not meet complexity requirements.
			$_SESSION["dbUpDate"]="Password does not meet complexity requirements. please try again. processAdminAdd.php";
			header('Location: '."addAdmin.php");
		}
	}
	else{//result failed. serious issue
		$_SESSION["dbUpDate"]="Major issue. Initial result query failed. processAddAdmin.php";
		header('Location: '."addAdmin.php");
	}
}
?>