<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP Process Simple Forms</title>
    <style type="text/css">
        .phpEcho {
    background-color: tan;
    border: thin black solid;
    padding: 25px;
	width: 450px;
    height: 6-0px;
}

.formLayout {
    background-color: #f3f3f3;
    border: solid 1px #a1a1a1;
    padding: 10px;
    width: 400px;
    height: 550px;
}
         
.formLayout label, .formLayout div {
    text-align: right;
    padding-right: 20px;
}

br {
    clear: both;
}
    </style>
</head>
<body>
<h2>Response PHP</h2>
<div class="phpEcho">
    
    <?php
	
	$strcheckBox = "default checkbox data";
    $strUserName = filter_input(INPUT_POST, "txtUserName");
    $strtrueFalse = filter_input(INPUT_POST, "trueFalse");
	$strmultiChoiceRadio = filter_input(INPUT_POST, "multiChoiceRadio");
	if (filter_has_var(INPUT_POST, "checkBox")){
		$strcheckBox = filter_input(INPUT_POST, "checkBox");
	}
	$stressayQ = filter_input(INPUT_POST, "essayQ");
	$strselectAnswer = filter_input(INPUT_POST, "selectAnswer");

$strPrint =<<<HERE
Hello, $strUserName !<br>
You're answers are as follows:<br>
$strtrueFalse , $strmultiChoiceRadio , $strcheckBox , $stressayQ , $strselectAnswer
HERE;

    print $strPrint;
    ?>

</div>
</body>
</html>