<?php
session_start();
$httpReferer = $_SESSION['addressOne']."/admin/changePass.php";

$oldPassCorrect = false; 
$newPassCorrect = false;
$hashPass = "";

// if the user is not authenticated, send them back to the log in page with a warning
if (!$_SESSION['loggedIn']){
	$_SESSION['loginWarn'] = 'You must be logged into the system to access the page. processPasswordChange';
	$_SESSION["logOnAttempt"] += 1;
	$_SESSION["loggedIn"] = false;
	unset($_SESSION['adminID']);
	unset($_SESSION['adminFName']);
	unset($_SESSION['adminLName']);
	unset($_SESSION['adminAuthLevel']);
	header('Location: '.'LogIn.php');
}
// check to see if the user came from the correct page.
if ($_SERVER['HTTP_REFERER'] != $httpReferer) {// The user did not come from the password change form, redirect them to the log in page
	$_SESSION["loginWarn"] = "You must be logged into the system to access the page. processPasswordChange.php error"; 
	$_SESSION["logOnAttempt"] += 1;
	$_SESSION["loggedIn"] = false;
	unset($_SESSION['adminID']);
	unset($_SESSION['adminFName']);
	unset($_SESSION['adminLName']);
	unset($_SESSION['adminAuthLevel']);
	header('Location: '.'LogIn.php'); 
}
else {

	// requiring the db connection file, this file must exist and included only once
	require_once("../includes/dbConstants.php");
	// check to see if the session variable for number of password has been created.  If not create it

	// create SQL statement to get old password from database
	// $_SESSION variables work best if concatenation to a string
	$sql = "SELECT password FROM admins WHERE userID = " . $_SESSION['adminID'] . ";"; 
	// execute the SQL statement against the database and assign returned records to a variable
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));

	// check to see if data was returned from the query
	if ($result) { // place result in associative array and capture the returned data
		while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) { 
			$storedPass = $row["password"];
		}
	}
	// no data was returned from query, send user back to password change page with error message
	else {
	$_SESSION["loginWarn"] = "Record could not be found in database. processPasswordChange.php error";
	$_SESSION["passChangeAttempt"] += 1;//? not sure what to do with this.
	header('Location: '."changePass.php");
	}
	
	// encrypt  hash the password submitted through form and assign it to a variable
	$hashPass = hash('sha256', $_POST['pswOld']);

	// check for first log in
	if (($_POST['pswOld'] == 'Nothing!1') && ($storedPass == 'Nothing!1')){
		$oldPassCorrect = true;
	}
	// else check stored, hashed password against against entered, hashed password
	elseif ($hashPass == $storedPass){
		$oldPassCorrect = true;
	}
	
	else {// entered old password does not match stored password
		$_SESSION["passChangeAttempt"] += 1;
		$_SESSION["loginWarn"] = "Old password is incorrect. processPasswordChange.php error"; 
		header('Location: '."changePass.php"); 
	}
	// if the user entered the old password correctly, $oldPassCorrect will have a value of true
	if ($oldPassCorrect){
		if ($_POST['pswWord'] == $_POST['pswConf'] && $_POST['pswOld'] != $_POST['pswWord']){
			$re = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&*()]).{8,}/";// check to see if new password meets complexity
			if (preg_match($re, $_POST['pswWord'])) {// all complexity requirements have been met
				$newPassCorrect = true;
			}
			// new password does not meet complexity, return to password change, up attempts, give warning 
			else {
				$_SESSION["passChangeAttempt"] += 1;
				$_SESSION["loginWarn"] = "Password must be different from old password, and must meet complexity requirements. processPasswordChange.php error";
				header('Location: '."changePass.php");
			}
		}
		// new password and confirmed password do not match return to password change page, up attempts, give warning
		else {
			$_SESSION["passChangeAttempt"] += 1;
			$_SESSION["loginWarn"] = "New passwords do not match. Please retype your new password. processPasswordChange.php error";
			header('Location: '."changePass.php");
		} 
	}
	
	// all conditions have been met to write the new password to the database if $oldPassCorrect and $newPassCorrect are both true
	if ($oldPassCorrect && $newPassCorrect){
		// Hash the new password for storage in the database
		$hashPass = hash('sha256', $_POST['pswWord']); 
		// create SQL statement
		$sql = "UPDATE admins SET password = '". $hashPass . "' WHERE userID = " . $_SESSION['adminID'] . ";";
		// execute the sql statement
		$resulte = mysqli_query($con, $sql) or die(mysqli_error($con));
		// successful password change. Reset log in attempts to 0. inform user of successful password change. send back user to log in page, to use new credentials.
		$_SESSION["passChangeAttempt"] = 0;
		
		$_SESSION["logOnAttempt"] = 0;
		$_SESSION["loggedIn"] = false;
		unset($_SESSION['adminID']);
		unset($_SESSION['adminFName']);
		unset($_SESSION['adminLName']);
		unset($_SESSION['adminAuthLevel']);
		$_SESSION["loginWarn"] = "New passwords successfully set! Please Log in again using your new credentials. processPasswordChange cleared.";
		header('Location: '."LogIn.php");
	}
}
?>