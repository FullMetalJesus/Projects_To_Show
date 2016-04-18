<?php
session_start();
//resets global login variables if currently set. they will be re-set later.
$_SESSION["loggedIn"] = false;
unset($_SESSION['adminID']);
unset($_SESSION['adminFName']);
unset($_SESSION['adminLName']);
unset($_SESSION['adminAuthLevel']);

// create variables for accepted refering pages
$refer1 = $_SESSION['addressOne']."/admin/LogIn.php";

if ($_SERVER['HTTP_REFERER'] != $refer1){// check to see if the referring page is correct, if not, send the user back to the log in page
		$_SESSION["loginWarn"] = "Referring Page Incorrect.Please try logging in again.ProcessPage error.";
		$_SESSION["logOnAttempt"] += 1;
		$_SESSION["loggedIn"] = false;
		header('Location: '.'LogIn.php');
}
else if ((!isset($_POST['txtUser'])) || (!isset($_POST['pswWord']))) {// check to see if the if the necessary vars have been set, if not, send the user back to the log in page
    $_SESSION["loginWarn"] = "Necessary variables are not set.Please try logging in again.ProcessPage error.";
	$_SESSION["logOnAttempt"] += 1;
	$_SESSION["loggedIn"] = false;
	header('Location: '.'LogIn.php');
}
else {//variables and data received from LogIn.php.
    require_once("../includes/dbConstants.php");
	//yields $con = mysqli_connect(DB_HOST=localhost, DB_USER=root, DB_USER_PASS='', DB_NAME=rega1962);

	// assign variable names
    $adminLogin = $_POST['txtUser'];
    $adminPass = $_POST['pswWord'];
	
	// used for encrypting the user's password, clear hash if exists
    $hash = "";

    // set default number of records found in DB
    $recCount = 0;

    // start SQL statement
    $sql = "SELECT userID, firstName, lastName, adminLevel, COUNT(*) AS numRecs FROM admins WHERE login = '$adminLogin' AND password = ";

    // check to see if default password is being used. End the SQL statement.
    if ($adminPass == "Nothing!1"){
        // User is signing for the first time
        $sql .= "'$adminPass';";
    }
    else {
        // User has signed in before, encrypt the password. End the SQL statement.
        $hash = hash('sha256', $adminPass);
        $sql .= "'$hash';";
    }
    
    // run the query using mysqli_query
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));

    if ($result){// Get data as an associative array
    
        while ($row = mysqli_fetch_array ($result,MYSQLI_ASSOC)){// assign the count of records to a variable
            $recCount = $row['numRecs'];//$row['numRecs'] - produces a string variable like: '1' '2' '3' '0' ...etc.
        }
		
		if ($recCount == '0'){// test number of records returned.  a value of '0' means no record found in DB.
			$_SESSION["loginWarn"] = "Log in failed; Invalid userID or password, no record matched.ProcessPage error.";
			$_SESSION["logOnAttempt"] += 1;
			$_SESSION["loggedIn"] = false;
			header('Location: '.'LogIn.php');
		}
		else if ($recCount != '0'){// a user record was found
			//save user info in session variable
			//redirect the user to the correct page
			//if using default password send to password change page
			//else send user to administrative menu
			$row2="";//create new var to hold second query
			$result2=mysqli_query($con, $sql) or die(mysqli_error($con));//create new var to hold second query
            while ($row2 = mysqli_fetch_array ($result2,MYSQLI_ASSOC)) {// create Session variables to hold administrator's information.
				$_SESSION['adminID'] = $row2['userID'];
				$_SESSION['adminFName'] = $row2['firstName'];
				$_SESSION['adminLName'] = $row2['lastName'];
				$_SESSION['adminAuthLevel'] = $row2['adminLevel'];
				$_SESSION['loggedIn'] = true;
				$_SESSION["logOnAttempt"] = 0;				
			}
			if($_POST['pswWord']=='Nothing!1'){//if first time logging in, send to change pass
				header('Location: '.'changePass.php');
			}
			else{//else send user to admin menu.
				header('Location: '.'menu.php');
			}
		}
	}
	else{
		$_SESSION["loginWarn"] = "Something went horribly wrong with the mysqli user query results, because this should be covered by or die(mysqli_error(con)). Please contact the administrator. ProcessPage.";
		//no penalty here, not sure what would be wrong.
		header('Location: '.'LogIn.php');
	}
}
?>