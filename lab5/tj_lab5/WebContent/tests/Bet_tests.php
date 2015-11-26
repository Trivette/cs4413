<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Basic tests for Bet</title>
</head>
<body>
<h1>Bet tests</h1>

<?php
include_once("../models/Bet.class.php");
?>

<h2>It should create a valid Bet object when all input is provided</h2>
<?php 
$validTest = array("game" => "123123",
                   "betAmount" => "10");
$s1 = new Bet($validTest);
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

<h2>It should not allow a bet more than 10</h2>
<?php 
$validTest = array("game" => "123123",
                   "betAmount" => "11");
$s1 = new Bet($validTest);
echo "$s1<br>";
$test2 = (empty($s1->getErrors()))?'':'Failed: It should have errors when invalid input is provided<br>';
echo $test2;
if($test2 != "")
	echo implode("|", $s1->getErrors());
?>

<h2>It should not allow a bet less than 1</h2>
<?php 
$validTest = array("game" => "123123",
                   "betAmount" => "-1");
$s1 = new Bet($validTest);
echo "$s1<br>";
$test2 = (empty($s1->getErrors()))?'':'Failed: It should have errors when invalid input is provided<br>';
echo $test2;
if($test2 != "")
	echo implode("|", $s1->getErrors());
?>