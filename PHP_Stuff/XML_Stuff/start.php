<?php
session_start();
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
				
				$("#myForm").validate({//runs the validation with specific rules real time while end-user enters data
					rules:{
						isbn10 : {
							alphanumeric: true,
							minlength: 10,
							maxlength: 10
						},
						title : {
							minlength: 2
						},
						fName : {
							minlength: 2,
							lettersonly: true
						},
						lName : {
							minlength: 2,
							lettersonly: true
						},
						publication_date : {
							date: true
						},
						price : {
							number: true,
							maxlength: 5
						}
					}
				});
			
				$( ".button1" ).click(function() {//submit button coding
					if ( $( "#myForm" ).valid() ){
						$("#myForm").submit();
					}
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
	<body >
		<div id="header">
			<br>
			<h1>Book Input Form</h1>
			<br>
		</div>
		<div id="leftbar" >

		</div>
		<div id="middlebar" >
			<div id="bookinfo" >
				<br>
				<br>
				<form id="myForm" action="processing.php" method="post">
					Enter Book ISBN-10 Number(i.e. 927386547f): <input type="text" id="isbn10" name="isbn10" class="required" size="20" >
					<br>
					<br>
					Enter Book Title: <input type="text" id="title" name="title" class="required" size="20" >
					<br>
					<br>
					Enter Authors First Name: <input type="text" id="fName" name="fName" size="40" class="required" >
					<br>
					<br>
					Enter Authors Last Name: <input type="text" id="lName" name="lName" size="40" class="required" >
					<br>
					<br>
					Enter Publication Date(i.e. 10/31/2004): <input type="text" id="publication_date" name="publication_date" size="40" class="required">
					<br>
					<br>
					Enter Book Price (numbers only)$: <input type="text" id="price" name="price" size="5">
					<br>
					<br>
					<input type="button" name="button1" class="button1" value="submit button">
				</form>
			</div>
		</div>
		<div id="rightbar">
		
		</div>	
	</body>
</html>