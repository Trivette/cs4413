<?php
class HomeView {
  public static function show() {  
		
?>
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="UTF-8">
	<title>Hock League</title>
	</head>
	<body>
	<section>
	<nav>
		<a href="signup">Register</a> |
		<a href="login">Login</a> |
		<a href="http://imightbejosh.com/ranks.html">Leaderboard</a> |
		<a href="bet.html">Betting</a> |
		<a href="games.html">Recent Games</a>
	</nav>
	<img src="resources/Drawing.png" alt="Banner">
	</section>
	Want to view an empty user profile page?  <a href="profile">Sure!</a>
	<section>
		<header>
		<p>This is a web site for Hock League in Uniball.  Here you will find a leaderboard and player statistics.  You will also have the ability to bet on games here.</p>
		</header>
		<aside>
			<h4>Uniball</h4>
			<p>Uniball is an online multi-player space hockey video game.  Click <a href="http://uniballhq.com">here</a> for more information.</p>
			<h4>Hock League</h4>
			<p>Hock League is the name of the premier Uniball league dedicated to competitive 3v3 games on the Hockey map.</p>
		</aside>
	</section>
	
	<footer>
	<p>Contact Information: <a href="mailto:joshuatrivette@gmail.com">joshuatrivette@gmail.com</a></p>
	</footer>
	</body>
	</html>
<?php
  }
}
?>