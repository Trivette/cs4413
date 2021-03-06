<?php
class SignupView {
	public static function show($userdata) {
		$_SESSION['headertitle'] = "Register";
		$_SESSION['styles'] = array('jumbotron.css');
	  	MasterView::showHeader();
	  	MasterView::showNav();
	  	SignupView::showDetails($userdata);
	  	MasterView::showPageEnd();
	}
  	
  	public static function showDetails($userdata) {
?>
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
	Hock user name: <input type="text" name="hockName" tabindex="4" <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->gethockName() .'"';}?> required>
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('hockName');}?>
	</span>
	<br>
	Email: <input type="email" name="email" tabindex="5" <?php if (!is_null($userdata)) {echo 'value = "'. $userdata->getEmail() .'"';}?> required>
	<span class="error">
	<?php  if (!is_null($userdata)) {echo $userdata->getError('email');}?>
	</span>
	<br> <br>
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
<?php 
  }
}
?>