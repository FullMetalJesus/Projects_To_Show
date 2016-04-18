<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <title>PHP Listing Directory Contents</title>
     <!--
     Marti Baker
     CIS 243 Web Dev III
     -->
     <meta charset="utf-8">
     <meta name="author" content="Marti Baker">
     <meta name="robots" content="NOINDEX, NOFOLLOW">
<style type="text/css">
body {
    margin: 10px;
    padding: 25px;
}

.formLayout {
    background-color: #f3f3f3;
    border: solid 1px #a1a1a1;
    padding: 10px;
    width: 300px;
    height: 115px;
}
    
.formLayout label, .formLayout input {
    display: block;
    width: 120px;
    float: left;
    margin-bottom: 10px;
}
 
.formLayout label {
    text-align: right;
    padding-right: 20px;
}
    
#cmdSubmit {
    margin: 0 100px;
}

.example {
    font-family: monospace;
    color: green;
    font-size: larger;
    font-weight: bold;
}
        
.phpEcho {
    background-color: tan;
    border: thin black solid;
    padding: 25px;
}

br {
    clear: both;
}
</style>
</head>
<body>
<h2>PHP Listing Directory Contents</h2>
<div class="phpEcho">
<?php
$xml = simplexml_load_file("books.xml");

var_dump($xml);
?>
</div>
</body>
</html>