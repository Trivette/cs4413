<?php
class BetView {
	public static function show($bet) {
		$_SESSION['headertitle'] = "Betting";
		$_SESSION['styles'] = array('jumbotron.css', 'games.css');
		MasterView::showHeader();
		MasterView::showNav();
		BetView::stuff();
		BetView::showGames();
		BetView::showDetails($bet);
		MasterView::showFooter(null);
		MasterView::showPageEnd();
	}
	
	public static function stuff(){
		echo '<div class="container">';
		echo '<span id="games">';
	}
	
	public static function showDetails($bet){
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
		echo '</span>';
		echo '<h3>Generate a new game randomly to test</h3>';
		echo '<button type="button">Generate New Game</button>';
		echo '</div>'; //end container
		?>
			<script>
			$(document).ready(
				function(){
			       $("button").click(
			    	   function(){
			              $.ajax({url:<?php echo '"/'.$base.'/bet/generate"'; ?>, 
			    	      success: function(result){$("#games").html(result);}
			            });
			     });
			});
			</script>
		<?php 
	}
		
	public static function showGames() {
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
		//echo '<div class="container">';
		echo '<h1>Bet On These Active Games</h1>';
		//$games = (array_key_exists('activegames', $_SESSION))?$_SESSION['activegames']:array();
		$games = GameDB::getGamesBy('pending', 1);
		if(empty($games)){
			//echo '</div>';
			return;
		}
		echo '<div class="table-responsive">';
		echo '<table class="table">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>GameID</th>';
		echo '<th>User1</th>';
		echo '<th>User2</th>';
		echo '<th>User3</th>';
		echo '<th>TeamSkill</th>';
		echo '<th>+/-</th>';
		echo '<th>User4</th>';
		echo '<th>User5</th>';
		echo '<th>User6</th>';
		echo '<th>TeamSkill</th>';
		echo '<th>+/-</th>';
		echo '<th>Length</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		
		//iterate through all games
		foreach($games as $game){
			//If the game is not finished or had a bad/cancel don't show here
			if($game->getPending() != 1)
				continue;
			$teams = TeamDB::getTeamsBy('id', $game->getTeamID1());
			if(empty($teams))
				break;
			$team1 = $teams[0];
			$teams = TeamDB::getTeamsBy('id', $game->getTeamID2());
			if(empty($teams))
				break;
			$team2 = $teams[0];
			if(is_null($team1) || is_null($team2))
				break;
				
			$worth = GameController::calcWorth($game->getTeamSkill1(), $game->getTeamSkill2());
			
			//team1
			$user1 = HockUserDB::getUsersBy('id', $team1->getUID1());
			$user2 = HockUserDB::getUsersBy('id', $team1->getUID2());
			$user3 = HockUserDB::getUsersBy('id', $team1->getUID3());
			//team2
			$user4 = HockUserDB::getUsersBy('id', $team2->getUID1());
			$user5 = HockUserDB::getUsersBy('id', $team2->getUID2());
			$user6 = HockUserDB::getUsersBy('id', $team2->getUID3());
				
			if(empty($user1) || empty($user2) || empty($user3) || empty($user4) || empty($user5) || empty($user6))
				break;
				
			$user1 = $user1[0];
			$user2 = $user2[0];
			$user3 = $user3[0];
			$user4 = $user4[0];
			$user5 = $user5[0];
			$user6 = $user6[0];
				
			$start = new DateTime($game->getStart());
			$end = new DateTime(date("Y-m-d H:i:s"));
			
			$length = $start->diff($end);
				
				
			echo '<tr class="'.$game->getServer().'">';
			echo '<td class="'.$game->getServer().'">'.$game->getID().'</td>';
			echo '<td class="'.$user1->getHome().'"><a href="/' . $base . '/user/show/' . $user1->getUserName() . '">'.$user1->getUserName().'</td>';
			echo '<td class="'.$user2->getHome().'"><a href="/' . $base . '/user/show/' . $user2->getUserName() . '">'.$user2->getUserName().'</td>';
			echo '<td class="'.$user3->getHome().'"><a href="/' . $base . '/user/show/' . $user3->getUserName() . '">'.$user3->getUserName().'</td>';
			echo '<td>'.$game->getTeamSkill1().'</td>';
			echo '<td class="edge">+'.$worth[0].'/-'.$worth[1].'</td>';
			echo '<td class="'.$user4->getHome().'"><a href="/' . $base . '/user/show/' . $user4->getUserName() . '">'.$user4->getUserName().'</td>';
			echo '<td class="'.$user5->getHome().'"><a href="/' . $base . '/user/show/' . $user5->getUserName() . '">'.$user5->getUserName().'</td>';
			echo '<td class="'.$user6->getHome().'"><a href="/' . $base . '/user/show/' . $user6->getUserName() . '">'.$user6->getUserName().'</td>';
			echo '<td>'.$game->getTeamSkill2().'</td>';
			echo '<td>+'.$worth[1].'/-'.$worth[0].'</td>';
			echo '<td>'.$length->i.'m '.$length->s.'s</td>';
			echo '</tr>';
				
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>'; //end table
		//echo '</div>'; //end container
		return;
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