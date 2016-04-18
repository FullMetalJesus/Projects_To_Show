<?php
session_start();
	$isbn10 = $_SESSION["isbn10"];
    $title = $_SESSION["title"];
	$authorName = $_SESSION["authorName"];
	$publication_date = $_SESSION["publication_date"];
	$price = $_SESSION["price"];
	$statusMessage = $_SESSION['message'];//book registration status
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Input Form Page</title>
		<meta charset="utf-8">
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
		<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>  
		<script type="text/javascript">
			$("document").ready ( function() {
				$( ".button1" ).click(function() {//back button coding.
					window.location.assign("start.php");
				});
			});
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
			height: 75px;
			width: 100%;
			display: block;
			background-color: grey;
		}
		#leftbar {
			display: block;
			float: left;
			width: 100px;
			height: 1000px;
			background-color: red;
		}
		#middlebar {
			display: block;
			float: left;
			width: 700px;
			height: 1000;
			background-color: white;
		}
		#rightbar {
			display: block;
			float: right;
			width: 400px;
			height: 1000px;
			background-color: blue;
			text-align: left;
		}
		</style>
	</head>
	<body >
		<div id="header">
			<br>
			<?php
			echo "<h1>$statusMessage</h1>";
			?>
			<br>
		</div>
		<div id="leftbar" >

		</div>
		<div id="middlebar" >
			<div id="bookinfo" >
				<br>
				<?php
					$xml = simplexml_load_file("myXML.xml");
					//var_dump($xml);
					//print "<br><br>";
					$counter = 0;
					print strtoupper($xml->getName()) . "<br>";
					print "<hr>";
					foreach($xml->children() as $second_gen) {
					$counter++;
					print strtoupper($second_gen->getName()) . " " . $counter . "<br>";
					foreach ($second_gen->children() as $third_gen){
						print $third_gen->getName() . ": " . $third_gen . "<br>";
					}
					print "<hr>";
				}
				print "There are currently $counter books in the myXML.xml books list.<br>";
				?>
				<br>
				<br>
				<button type="button" name="button1" class="button1">return to start</button>
			</div>
		</div>
		<div id="rightbar">
		
		</div>	
	</body>
</html>