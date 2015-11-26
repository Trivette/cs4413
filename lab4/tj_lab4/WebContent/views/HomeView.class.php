<?php
class HomeView {
	public static function show($user) {
		$_SESSION['headertitle'] = "HockLeague Home Page";
		$_SESSION['styles'] = array('jumbotron.css');
	  	MasterView::showHeader();
	  	MasterView::showNav();
	  	HomeView::showDetails($user);
     	MasterView::showHomeFooter();
     	MasterView::showPageEnd();
	}
	
	public static function showDetails($user) {  
  	$base = $_SESSION['base'];
  	
?>
	<div class="jumbotron">
	<div class="container">
	<h1>HockLeague</h1>
	<p>This is a web site for Hock League in Uniball.  Here you will find a leaderboard and player statistics.</p>
	</div>
	</div>
	<?php 
		$webusers = WebUserDB::getLastUsers();
		if(!empty($webusers)){
			echo '<div class="container">';
			echo '<h3>Welcome Our 3 Newest Users</h3>';
			echo '<p>'.implode(", ",$webusers).'</p>';
			echo '</div>';
		}
	?>
	<hr>
	<section>
		<aside>
			<h1>Uniball</h1>
			<p>Uniball is an online multi-player space hockey video game.  Click <a href="http://uniballhq.com">here</a> for more information.</p>
			<h1>Hock League</h1>
			<p>Hock League is the name of the premier Uniball league dedicated to competitive 3v3 games on the Hockey map.</p>
		</aside>
	</section>
<?php
  }
}
?>