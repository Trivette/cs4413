<?php
class SignupView {
  public static function show($userdata) {  
		
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
	<form action="signup" method="post">
	<p>
	User name: <input type="text" name="userName" tabindex="1" <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->getUserName() .'"';}?> required>
	<span class="error">
	   <?php if (!is_null($userdata)) {echo $userdata->getError('userName');}?>
	</span>
	<br>
	Password: <input type="password" name="password" tabindex="2" required>
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('password');}?>
	</span>
	<br>
	Confirm Password: <input type="password" name="confirmedpw" tabindex="3" required>
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('confirmedpw');}?>
	</span>
	<br> <br>
	Hock user name: <input type="text" name="hockUser" tabindex="4" <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->getHockUser() .'"';}?> required>
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('hockUser');}?>
	</span>
	<br>
	Email: <input type="email" name="email" tabindex="5" <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->getEmail() .'"';}?> required>
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('email');}?>
	</span>
	<br> <br>
	Gender: 
	<input type="radio" name="gender" value="male" required <?php if (!is_null($userdata)) {if($userdata->getGender() == "male"){ echo 'checked';}}?> tabindex="6">Male 
	<input type="radio" name="gender" value="female" <?php if (!is_null($userdata)) {if($userdata->getGender() == "female"){ echo 'checked';}}?>>Female
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('gender');}?>
	</span>
	<br>
	Birthday: <input type="date" name="dob" tabindex="7" required <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->getDOB() .'"';}?>>
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('dob');}?>
	</span>
	<br> <br>
	Favorite Ship Color: <input type="color" name="color" tabindex="8" <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->getColor() .'"';}?>>
	<br>
	Upload a profile picture: <input type="file" name="picture" tabindex="9" required <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->getPicture() .'"';}?>>
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('picture');}?>
	</span>
	<br>
	URL: <input type="url" name="url" tabindex="10" <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->getURL() .'"';}?>>
	<br> <br>
	<fieldset>
	<legend>Acknowledgement:</legend>
	<input type="checkbox" name="acknowledgement" value="Papers" tabindex="14" required> I am who I say I am<br>
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