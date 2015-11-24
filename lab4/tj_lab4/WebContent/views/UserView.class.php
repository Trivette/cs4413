<?php  
class UserView {

	public static function showAll() {
		// Show a table of users with links
		$_SESSION['headertitle'] = "Leaderboard";
		$_SESSION['styles'] = array('jumbotron.css');
		MasterView::showHeader();
		MasterView::showNav();
		//if (array_key_exists('headertitle', $_SESSION)) {
		//	MasterView::showHeader();
		//	MasterView::showNav();
		//}
		$users = (array_key_exists('users', $_SESSION))?$_SESSION['users']:array();
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
		
		echo "<center>";
		echo "<h1>Hock League Ranks</h1>";
		echo "<table border='1'>";
		echo "<thead>";
		echo "<tr><TH>Rank</th><th>Name</th><th>Skill</th><th>Wins</th><th>Losses</th><th>Total Games</th><th>Goals</th><th>Assists</th><th>Own Goals</th><th>GPG</th><th>APG</th><th>OGPG</th><TH>Bads</th><TH>Streak</th><th>Alias</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		$ct = 0;
		foreach($users as $user) {
			$wins = $user->getWins();
			$losses = $user->getLosses();
			$numgames = $wins + $losses;
			//In the future these people will be left off the leaderboard
			if($numgames == 0)
				$numgames = 1;
			
			
			$ct += 1;
			$bgcolor = '';
			$colorstyle = '';
			if($user->getStreak() >= 5)
				$bgcolor = " bgcolor='ff6600'";
			elseif($user->getStreak() <= -5)
				$bgcolor = " bgcolor='33ccff'";
			if(strcmp($user->getHome(), 'east') == 0)
				$colorstyle = '"color:orange"';
			elseif(strcmp($user->getHome(), 'uk') == 0)
				$colorstyle = '"color:blue"';
			elseif(strcmp($user->getHome(), 'mw') == 0)
				$colorstyle = '"color:red"';
			elseif(strcmp($user->getHome(), 'west') == 0)
				$colorstyle = '"color:green"';
			
			echo '<tr' . $bgcolor . '>';
			echo '<td style=' . $colorstyle . '> '. $ct .'</td>';
			echo '<td><a href="/' . $base . '/user/' . $user->getUserName() . '">' . $user->getUserName() . '</td>';
			echo '<td>'.$user->getSkill().'</td>';
			echo '<td>'.$wins.'</td>';
			echo '<td>'.$losses.'</td>';
			echo '<td>'.($wins + $losses).'</td>';
			echo '<td>'.$user->getGoals().'</td>';
			echo '<td>'.$user->getAssists().'</td>';
			echo '<td>'.$user->getOwnGoals().'</td>';
			echo '<td>'.round($user->getGoals()*1.0 / $numgames, 2).'</td>';
			echo '<td>'.round($user->getAssists()*1.0 / $numgames, 2).'</td>';
			echo '<td>'.round($user->getOwnGoals()*1.0 / $numgames, 2).'</td>';
			echo '<td>'.$user->getBads().'</td>';
			echo '<td>'.$user->getStreak().'</td>';
			echo '<td>'.$user->getAlias().'</td>';
			echo '</tr>';
		}
		echo "</tbody>";
		echo "</table>";
		echo "</center>";
		//if (array_key_exists('footertitle', $_SESSION))
		//	MasterView::showFooter(null);
		MasterView::showFooter(null);
	}
}
?>	