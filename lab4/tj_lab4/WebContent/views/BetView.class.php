<?php
class BetView {
	public static function show($bet) {
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
		
		MasterView::showHeader("Betting");
		MasterView::showNav(null);
		BetView::showDetails($bet);
		MasterView::showFooter(null);
		}
		
		public static function showDetails($bet) {
		
?>
	<h3> Active games </h3>
	(29678)  Team1: Sergio ace lymp (4502) +10/-10    Team2: zoop bizarre staniol (4480)  +10/-10    0:02:56.805000
	<br>
	<h3>Place bet:</h3>
	<form action="bet" method="post">
	Game to bet on: <input type="text" name="game" tabindex="1" <?php if (!is_null($bet)) {echo 'value = "'. $bet->getGame() .'"';}?> required>
	<span class="error">
	   <?php if (!is_null($bet)) {echo $bet->getError('game');}?>
	</span>
	<br>
	Amount to bet: <input type="text" name="betAmount" tabindex="2" <?php if (!is_null($bet)) {echo 'value = "'. $bet->getBetAmount() .'"';}?> required>
	<span class="error">
	   <?php if (!is_null($bet)) {echo $bet->getError('betAmount');}?>
	</span>
	<br>
	<input type="submit" value="Submit" tabindex="3">
	</form>
<?php
  }
}
?>