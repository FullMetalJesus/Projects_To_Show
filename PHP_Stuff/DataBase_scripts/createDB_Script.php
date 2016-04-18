<?php
// connection info
$host = "localhost";
$port = 3306;
//$socket = "";
$user = "root";
$password = ""; 
$dbname= "mysql";
//--------CONNECT TO SQL DB----------------
$sqlConnection = new mysqli($host, $user, $password, $dbname) or die ('Could not connect to the database server' . mysqli_connect_error() . '(10)<br><br>');

if (!$sqlConnection) {//verification stuff
    die('Could not connect to localhost DB named mysql: ' . mysqli_error($sqlConnection) . " (12)<br><br>");
}
else {//verification stuff
    echo("Connection has been made to localhost DB name mysql.(16)<br><br>");
}
//---------------------------------
//**************Drop Existing Database and Re-Create*****************
$sqlCommand = "DROP DATABASE IF EXISTS davidRegalado_PizzaParlor;";

if (mysqli_query($sqlConnection,$sqlCommand)){	//verification stuff
    echo "Existing davidRegalado_PizzaParlor DB dropped. (21)<br><br>";
}
else {//verification stuff
    echo "davidRegalado_PizzaParlor DB does not exist or the drop failed: " . mysqli_error($sqlConnection) . "(25)<br><br>";
}

$sqlCommand = "CREATE DATABASE IF NOT EXISTS davidRegalado_PizzaParlor DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

if (mysqli_query($sqlConnection,$sqlCommand)){	//verification stuff
    echo "DB davidRegalado_PizzaParlor created.  (30)<br><br>";
}
else {//verification stuff
    echo "DB davidRegalado_PizzaParlor was not created: " . mysqli_error($sqlConnection) . "(33)<br><br>";
}

$sqlConnection->close(); //closes current DB object.

echo "Connection to localhost DB named mysql closed.(36)<br><br>";	//verification stuff

//***********************************************************************
//------------------------CONNECT to Pizza Parlor DB-----------------------
$dbname="davidRegalado_PizzaParlor";

$sqlConnection = new mysqli($host, $user, $password, $dbname)
    or die ('Could not connect to the database' . mysqli_connect_error() . '(43)<br><br>');

if (!$sqlConnection) {
    die('Could not connect to localhost DB named davidRegalado_PizzaParlor: ' . mysqli_error($sqlConnection) . " (46)<br><br>");
}
else {
    echo("Connection has been made to localhost DB name davidRegalado_PizzaParlor. (49)<br><br>");
}	
//-------------------------------------------------------------------------
//*************************DROP AND CREATE ADMIN TABLE **********************************
$sqlCommand = "DROP TABLE IF EXISTS ADMIN;";
if (mysqli_query($sqlConnection,$sqlCommand)){
    echo "Admin table dropped. Now attempting to re-create table... (55)<br><br>";
}
else {
    echo "Admin table not dropped or did not exist: " . mysqli_error($sqlConnection) . ". Now attempting to create table...(58)<br><br>";
}

/*$sqlCommand = "CREATE TABLE IF NOT EXISTS 'ADMIN' (USERID INTEGER AUTO_INCEREMENT PRIMARY KEY NOT NULL, LOGIN VARCHAR(25), FIRSTNAME VARCHAR(25), LASTNAME VARCHAR(25), PASSWORD VARCHAR(300), ADMINLEVEL INTEGER DEFAULT '2');";*/

$sqlCommand = "CREATE TABLE admin2 ( userid int(11) NOT NULL AUTO_INCREMENT, login varchar(25) DEFAULT NULL, firstname varchar(25) DEFAULT NULL, lastname varchar(25) DEFAULT NULL, password varchar(300) DEFAULT NULL, adminlevel int(11) DEFAULT 2, PRIMARY KEY (userid) );";

echo $sqlCommand . "<br><br>";


if (mysqli_query($sqlConnection,$sqlCommand)){
    echo "Admin table created (64)<br>";
}
else {
    echo "Admin table not created: " . mysqli_error($sqlConnection) . "(67)<br>";
}

$sqlCommand = "CREATE INDEX INDEX_LOGIN ON ADMIN (LOGIN);";
if (mysqli_query($sqlConnection,$sqlCommand)){
    echo "Created Index of Login column (72)<br>";
}
else {
    echo "Index of Login Column could not be created." . mysql_error($sqlConnection,$sqlCommand) . "(75)<br>";
}

//************************************************************************
//----------------INSERT VALUES INTO ADMIN TABLE----------------------------
$sqlCommand = "INSERT INTO ADMIN VALUES (1, 'default', 'Default', 'Admin', 'Noth1ng!', 1), (2, 'David', 'David', 'Regalado', 'Noth1ng!', 1), (3, 'Minnie', 'Minnie', 'Mouse', 'Noth1ng!', 2);";

if (mysqli_query($sqlConnection,$sqlCommand)){
    echo "Data inserted in Admin table (74)<br><br>";
}
else {
    echo "Error creating data in Admin table: " . mysql_error($sqlConnection) . "(77)<br>";
}
//--------------------------------------------------------------------------
$sqlConnection->close(); //closes current DB sql object.
echo "connection to localhost DB named davidRegalado_PizzaParlor closed.(81)<br><br>";//verification stuff
?>