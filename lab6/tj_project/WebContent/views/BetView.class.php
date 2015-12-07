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
		$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?$_SESSION['authenticatedUser']:null;
		if(!is_null($authenticatedUser)){
			?>
			<h4>Bet before game has been active for 5 minutes</h4>
			<h4>Min bet: 1, Max bet: 10</h4>
			<form action="bet" method="post">
			Game ID: <input type="number" name="game" required></input>
			<span class="error">
		   	<?php if (!is_null($bet)) {echo $bet->getError('game');}?>
			</span>
			<br>Amount: <input type="number" name="wager" min="1" max="10" required></input>
			<span class="error">
		   	<?php if (!is_null($bet)) {echo $bet->getError('wager');}?>
			</span>
			<br><input type="radio" name="team" value="team1" required></input> Left Team
			<input type="radio" name="team" value="team2"></input> Right Team
			<span class="error">
		   	<?php if (!is_null($bet)) {echo $bet->getError('team');}?>
			</span>
			<br><input type="submit" value="Submit">
			<span class="error">
		   	<?php if (!is_null($bet)) {echo $bet->getError('user');}?>
			</span>
			<br>
			<span class="success">
		   	<?php if (!is_null($bet) && $bet->getErrorCount() == 0 && $bet->getBetID() != 0) {echo "Success!  Bet Recorded!";}?>
			</span>
			</form>
			<?php 
		}
		echo '<h3>Generate a new game randomly to test</h3>';
		echo '<button type="button" class="generate">Generate New Game</button>';
		echo '</div>'; //end container
		?>
			<script>
			$(document).ready(
				function(){
			       $("button.generate").click(
			    	   function(){
			              $.ajax({url:<?php echo '"/'.$base.'/bet/generate"'; ?>, 
			    	      success: function(result){$("#games").html(result);}
			            });
			     });
			});
			</script>
		<?php 
		if(is_null($authenticatedUser)){
			return;
		}
		echo '<div class="container">';
		echo '<h1>Pending Games You Have Bets For</h1>';
		
		$bets = BetDB::getBetsBy('who', strtolower($authenticatedUser->getHockName()));
		if(empty($bets)){
			return;
		}
		$games = array();
		foreach($bets as $b){
			$game = GameDB::getGamesBy('id', $b->getGameID());
			if(empty($game))
				continue;
			$g = $game[0];
			if($g->getPending() == 1)
				array_push($games, $g);
		}
		if(empty($games)){
			echo '</div>';
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
		echo '<th>Bet</th>';
		echo '<th>Amount</th>';
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
			$timestr = "";
			if($length->m != 0)
				$timestr = $timestr.$length->m."mo ";
			if($length->d != 0)
				$timestr = $timestr.$length->d."d ";
			if($length->h != 0)
				$timestr = $timestr.$length->h."h ";
				
			$timestr = $timestr.$length->i."m ".$length->s."s";
			$bets = BetDB::findBet($game->getID(), $authenticatedUser->getHockName());
			$selected = "";
			$amount = "";
			if(!empty($bets)){
				$b = $bets[0];
				$selected = $b->getTeam();
				$amount = $b->getBetAmount();
			}
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
			echo '<td class="edge">'.$timestr.'</td>';
			echo '<td>'.$selected.'</td>';
			echo '<td>$'.$amount.'</td>';
			echo '</tr>';
		
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>'; //end container
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
		$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?$_SESSION['authenticatedUser']:null;
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
			if(!is_null($authenticatedUser)){
				$bets = BetDB::findBet($game->getID(), $authenticatedUser->getHockName());
				if(!empty($bets)){
					continue;
				}
			}
			
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
			$timestr = "";
			if($length->m != 0)
				$timestr = $timestr.$length->m."mo ";
			if($length->d != 0)
				$timestr = $timestr.$length->d."d ";
			if($length->h != 0)
				$timestr = $timestr.$length->h."h ";
			
			$timestr = $timestr.$length->i."m ".$length->s."s";
				
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
			echo '<td>'.$timestr.'</td>';
			echo '</tr>';
				
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>'; //end table
		//echo '</div>'; //end container
	}
}
?>