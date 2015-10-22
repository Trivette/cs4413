<?php  
class LoginView {
	
	public static function show($user) {
		$nav = 	"<nav>
		<a href='signup'>Register</a> |
		<a href='login'>Login</a> |
		<a href='http://imightbejosh.com/ranks.html'>Leaderboard</a> |
		<a href='bet'>Betting</a> |
		<a href='games.html'>Recent Games</a> |
		<a href='tests.html'>Tests</a> |
		<a href='validation.html'>Validation</a>
		</nav>
		<section>
		<a href='home'><img src='resources/Drawing.png' alt='Home'></a>
		</section>";
		
		MasterView::showHeader("Login");
		MasterView::showNav($nav);
		LoginView::showDetails($user);
		MasterView::showFooter(null);
	}
		
		public static function showDetails($user) {
?> 
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
		Password: <input type="password" name ="password" >
	<span class="error">
	   <?php  if (!is_null($user)) {echo $user->getError('password');}?>
	</span>
	</p>
	<p><input type="submit" value="Submit"></p>
	</form>
	<p>New user? <a href="register">Sign up here</a></p>
	</section>
<?php 
  }
}
?>