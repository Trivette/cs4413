<?php
class GameView {
	public static function showAll() {
		$_SESSION['headertitle'] = "Games";
		$_SESSION['styles'] = array('jumbotron.css', 'games.css');
		MasterView::showHeader();
		MasterView::showNav();
		GameView::showAllDetails();
		MasterView::showFooter(null);
		MasterView::showPageEnd();
	}
		
	public static function showAllDetails() {
		$base = $_SESSION['base'];
		$games = (array_key_exists('games', $_SESSION))?$_SESSION['games']:array();
		echo '<script src="/'.$base.'/js/sorttable.js"></script>';
		echo '<div class="container">';
		echo '<h1>All Games This Season</h1>';
		
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
			if($game->getPending() != 0)
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
			$plusminus = 0;
			
			//Put all winning teams on left side of table
			if(strcmp($game->getWinReports(), 'team1') == 0){
				//team1 won
				$plusminus = $worth[0];
				//team1
				$user1 = HockUserDB::getUsersBy('id', $team1->getUID1());
				$user2 = HockUserDB::getUsersBy('id', $team1->getUID2());
				$user3 = HockUserDB::getUsersBy('id', $team1->getUID3());
				//team2
				$user4 = HockUserDB::getUsersBy('id', $team2->getUID1());
				$user5 = HockUserDB::getUsersBy('id', $team2->getUID2());
				$user6 = HockUserDB::getUsersBy('id', $team2->getUID3());
				$winnerskill = $game->getTeamSkill1();
				$loserskill = $game->getTeamSkill2();
			} elseif(strcmp($game->getWinReports(), 'team2') == 0) {
				//team2 won
				$plusminus = $worth[1];
				//team1
				$user4 = HockUserDB::getUsersBy('id', $team1->getUID1());
				$user5 = HockUserDB::getUsersBy('id', $team1->getUID2());
				$user6 = HockUserDB::getUsersBy('id', $team1->getUID3());
				//team2
				$user1 = HockUserDB::getUsersBy('id', $team2->getUID1());
				$user2 = HockUserDB::getUsersBy('id', $team2->getUID2());
				$user3 = HockUserDB::getUsersBy('id', $team2->getUID3());
				$winnerskill = $game->getTeamSkill2();
				$loserskill = $game->getTeamSkill1();
			} else continue;
			
			if(empty($user1) || empty($user2) || empty($user3) || empty($user4) || empty($user5) || empty($user6))
				break;
			
			$user1 = $user1[0];
			$user2 = $user2[0];
			$user3 = $user3[0];
			$user4 = $user4[0];
			$user5 = $user5[0];
			$user6 = $user6[0];
			
			$start = new DateTime($game->getStart());
			$end = new DateTime($game->getEnd());
			$length = $start->diff($end);
			
			
			echo '<tr class="'.$game->getServer().'">';
			echo '<td class="'.$game->getServer().'">'.$game->getID().'</td>';
			echo '<td class="'.$user1->getHome().'"><a href="/' . $base . '/user/show/' . $user1->getUserName() . '">'.$user1->getUserName().'</td>';
			echo '<td class="'.$user2->getHome().'"><a href="/' . $base . '/user/show/' . $user2->getUserName() . '">'.$user2->getUserName().'</td>';
			echo '<td class="'.$user3->getHome().'"><a href="/' . $base . '/user/show/' . $user3->getUserName() . '">'.$user3->getUserName().'</td>';
			echo '<td>'.$winnerskill.'</td>';
			echo '<td class="plus">+'.$plusminus.'</td>';
			echo '<td class="'.$user4->getHome().'"><a href="/' . $base . '/user/show/' . $user4->getUserName() . '">'.$user4->getUserName().'</td>';
			echo '<td class="'.$user5->getHome().'"><a href="/' . $base . '/user/show/' . $user5->getUserName() . '">'.$user5->getUserName().'</td>';
			echo '<td class="'.$user6->getHome().'"><a href="/' . $base . '/user/show/' . $user6->getUserName() . '">'.$user6->getUserName().'</td>';
			echo '<td>'.$loserskill.'</td>';
			echo '<td class="minus">-'.$plusminus.'</td>';
			echo '<td>'.$length->i.'m '.$length->s.'s</td>';
			echo '</tr>';
			
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>'; //end table
		echo '</div>'; //end container
	}
}
?>