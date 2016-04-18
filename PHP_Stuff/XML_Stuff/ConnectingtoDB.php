<?php

/*
Warning:  This is file should be used for development
Do not run this file to create a production database.
For students in the Web program:  The information about user name and password for the bucket server are included 
within this script

ATTENTION STUDENTS:  You should change the name of the database being created to include a prefix of your initials.  Example:
mjb_tennisclub
*/

// create variables to hold connection information
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";                  // user for MySQL RDBMS on bucket is "root"
$password = "";                  // password for MySQL RDBMS on bucket is "root"
$dbname= "mysql";

// create the connection string to MySQL database management system
$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

// verify the connection, display error if connection is not made
if (!$con) {
    die('Could not connect: ' . mysqli_error() . " <br><br>");
}
else {
    echo("Connection has been made <br><br>");
}

?>