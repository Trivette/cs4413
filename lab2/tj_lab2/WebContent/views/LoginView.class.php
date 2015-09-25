<?php  
class LoginView {
	
  public static function show($user) {  	
?> 

	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>Login</title>
	<meta name= "keywords" content=" Hock League Login">
	<meta name="description" content = "Login for Hock league">
	</head>
	<body>
	<section>
	<h3>Log in</h3>
	<form action ="login" method="Post">
	<p>
	User name: <input type="text" name ="userName" 
	<?php if (!is_null($user)) {echo 'value = "'. $user->getUserName() .'"';}?>> 
	<span class="error">
	   <?php if (!is_null($user)) {echo $user->getError('userName');}?>
	</span>
	<br>
		User name: <input type="password" name ="pass" 
	<?php if (!is_null($pass)) {echo 'value = "'. $pass->getUserName() .'"';}?>> 
	<span class="error">
	   <?php if (!is_null($pass)) {echo $pass->getError('userName');}?>
	</span>
	</p>
	<p><input type="submit" value="Submit"></p>
	</form>
	<p>New user? <a href="register">Sign up here</a></p>
	</section>
	</body>
	</html>
<?php 
  }
}
?>