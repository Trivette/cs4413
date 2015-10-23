<?php  
class ProfileView {
	
	public static function show($webuser, $hockuser) {
		if(!is_null($hockuser)) 
			$header = $hockuser->getUserName() . ' Profile Page';
		else 
			$header = 'null Profile Page';
		
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
		
		MasterView::showHeader($header);
		MasterView::showNav($nav);
		ProfileView::showDetails($webuser, $hockuser);
		MasterView::showFooter(null);
	}
	
  	public static function showDetails($webuser, $hockuser) {  	
?> 
<section>
<h2><?php if (!is_null($hockuser)) {echo $hockuser->getUserName();}?>'s Profile</h2>
<p>Saved img name is: <?php if((!is_null($webuser))) {echo $webuser->getPicture();}?></p>
<img src="./resources/userpic.png" alt="User Picture Here">
</section>
<section>
<h4>Stats</h4>
<p>
Wins: 5 Losses: 10 Streak: -3 Skill: 1450
</p>
</section>
<section>
<h4>Recent Games</h4>
<p>
<?php 
	
?>
Game: (29507)  fakeuser		Thurgood	Prowler		(4572) +10		Ferocious	brood  	fiend 		(4579) -10	21m 18s<br>
Game: (29504)  Ferocious  	Prowler  	fakeuser 	(4630) +8		Q8ball  	Bandit  fiend 		(4522) -8	31m 21s<br>
Game: (29501)  fakeuser 	Bandit  	LogiTech=) 	(4589) +10		Q8ball  	turtle  Gamer 		(4584) -10	21m 32s<br>
Game: (29498)  fakeuser  	Bandit  	turtle 		(4502) +12		Gamer  		fiend  	Thurgood 	(4553) -12	29m 37s<br>
Game: (29497)  fakeuser  	Bandit  	jamez 		(4518) +11		LogiTech=)  turtle  Q8ball 		(4549) -11	17m 57s<br>
</p>
</section>
<section>
<h4>Contact information</h4>
<ul>
	<li><b>Email:</b> <?php if (!is_null($webuser)) {echo $webuser->getEmail();}?></li>
	<li><b>URL:</b> <a href="<?php if (!is_null($webuser)) {echo $webuser->getURL();}?>"><?php if (!is_null($webuser)) {echo $webuser->getURL();}?></a></li>
</ul>
</section>

<?php 
  }
}
?>