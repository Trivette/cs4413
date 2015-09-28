<?php
class SignupView {
  public static function show() {  
		
?>
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>Register</title>
	</head>
	<body>
	<section>
	<h3>Register Account</h3>
	<form action="simpleEcho.php" method="post">
	<p>
	User name: <input type="text" name="user" tabindex="1">
	<br>
	Password: <input type="password" name="pass" tabindex="2">
	<br>
	Confirm Password: <input type="password" name="pass2" tabindex="3">
	<br> <br>
	Hock user name: <input type="text" name="hockuser" tabindex="4">
	<br>
	Email: <input type="email" name="email" tabindex="5">
	<br> <br>
	Gender: 
	<input type="radio" name="gender" value="male" checked tabindex="6">Male 
	<input type="radio" name="gender" value="female">Female
	<br>
	Birthday: <input type="date" name="bday" tabindex="7">
	<br>
	Favorite Ship Color: <input type="color" name="color" tabindex="8">
	<br>
	Upload a profile picture: <input type="file" name="picture" tabindex="9">
	<br>
	URL: <input type="url" name="url" tabindex="10">
	<br> <br>
	<fieldset>
	<legend>Text Notifications</legend>
	<input type="radio" name="textnotify" value="yes" tabindex="11" checked>Yes I want texts
	<br>
	<input type="radio" name="textnotify" value="no" tabindex="12">No I don't want texts
	<br> <br>
	Cell Number: <input type="tel" name="phone_number" tabindex="13">
	</fieldset>
	<br> <br>
	<fieldset>
	<legend>Acknowledgement:</legend>
	<input type="checkbox" name="acknowledgement" value="Papers" tabindex="14"> I am who I say I am<br>
	</fieldset>
	<br>
	<input type="submit" value="Submit" tabindex="15">
	</form>
	</section>
	</body>
	</html>
<?php 
  }
}
?>