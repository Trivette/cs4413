<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for User</title>
</head>
<body>
<h1>User tests</h1>

<?php
include_once("../models/User.class.php");
?>

<h2>It should create a valid User object when all input is provided</h2>
<?php 
$validTest = array("userName" => "josht", "password" => "1234asdf");
$s1 = new User($validTest);
echo "The object is: $s1<br>";
$test1 = (is_object($s1))?'':
'Failed: It should create a valid object when valid input is provided<br>';
echo $test1;
$test2 = (empty($s1->getErrors()))?'':
'Failed: It should not have errors when valid input is provided<br>';
echo $test2;
?>

<h2>It should extract the parameters that went in</h2>
<?php 
$props = $s1->getParameters();
print_r($props);
?>

<h2>It should have an error when the user name contains invalid characters</h2>
<?php 
$invalidTest = array("userName" => "josht$", "password" => "123123");
$s1 = new User($invalidTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed: It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for userName is: ". $s1->getError('userName') ."<br>";
echo "The object is: $s1<br>";
?>

<h2>It should have an error when the password is empty</h2>
<?php 
$invalidTest = array("userName" => "josht", "password" => "");
$s1 = new User($invalidTest);
$test2 = (empty($s1->getErrors()))?'':
'Failed: It should have errors when invalid input is provided<br>';
echo $test2;
echo "The error for password is: ". $s1->getError('password') ."<br>";
echo "The object is: $s1<br>";
?>
</body>
</html>