<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for UserData</title>
</head>
<body>
<h1>UserData tests</h1>

<?php
include_once("../models/UserData.class.php");
?>

<h2>It should create a valid UserData object when all input is provided</h2>
<?php 
$validTest = array("userName" => "josht1234",
                   "password" => "Green123",
				   "confirmedpw" => "Green123",
	               "email" => "josh@gmail.com",
				   "dob" => "2015-12-12",
				   "hockUser" => "mop",
				   "color" => "#00FF00",
                   "gender" => "male");
$s1 = new UserData($validTest);
echo "$s1<br>";
$test2 = (empty($s1->getErrors()))?'':'Failed: It should not have errors when valid input is provided<br>';
echo $test2;
if($test2 != "")
	echo implode("|", $s1->getErrors());
?>

<h2>It should extract the parameters that went in</h2>
<?php 
$props = $s1->getParameters();
print_r($props);
?>

<h2>Here is an example of a bunch of bad input and all the errors it will throw</h2>
<?php 
$validTest = array("userName" => "as asdfioj $",
                   "password" => "green",
				   "confirmedpw" => "green123",
	               "email" => "",
				   "dob" => "",
				   "hockUser" => "",
				   "color" => "#00FF00",
                   "gender" => "");
$s1 = new UserData($validTest);
$props = $s1->getParameters();
print_r($props);
echo "<br>";
if($test2 != "")
	echo implode("<br>", $s1->getErrors());
?>