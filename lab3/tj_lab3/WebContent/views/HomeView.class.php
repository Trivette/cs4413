<?php
class HomeView {
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
  		$footer = "Contact Information: <a href='mailto:joshuatrivette@gmail.com'>joshuatrivette@gmail.com</a>";
	  	MasterView::showHeader("Hock League");
	  	MasterView::showNav($nav);
	  	HomeView::showDetails($user);
     	MasterView::showFooter($footer);
  }
  
  public static function showDetails($user) {  
		
?>
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
<?php
  }
}
?>