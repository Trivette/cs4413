<?php  
class ProfileView {
	
	public static function show($webuser, $hockuser) {
		if(!is_null($hockuser)) 
			$header = $hockuser->getUserName() . ' Profile Page';
		else 
			$header = 'null Profile Page';
		
		$_SESSION['headertitle'] = $header;
		$_SESSION['styles'] = array('jumbotron.css', 'profile.css', 'games.css');
		
		MasterView::showHeader();
		MasterView::showNav();
		ProfileView::showDetails($webuser, $hockuser);
		if(array_key_exists('authenticatedUser', $_SESSION)){
			$authenticatedUser = $_SESSION['authenticatedUser'];
			if(!is_null($authenticatedUser)){
				if(strcmp($authenticatedUser->getHockName(), $hockuser->getUserName()) == 0){
					ProfileView::showUpdateButton();
				}
			}
		}
		MasterView::showPageEnd();
	}
	
  	public static function showDetails($webuser, $hockuser) {  	
  		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
  		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:"";
?> 
<div class="container-fluid">
<h2><?php if (!is_null($hockuser)) {echo $hockuser->getUserName();}?>'s Profile</h2>
</div>
<section>
<?php		
		//<p>Saved img name is: <?php if((!is_null($webuser))) {echo $webuser->getPicture();}</p>
		if(!is_null($hockuser)){
			echo '<div class="container-fluid">';
			echo '<h4>Game Stats</h4>';
			echo '<div class="table">';
			echo '<table class="table" id="stats1">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Wins</th>';
			echo '<th>Losses</th>';
			echo '<th>Streak</th>';
			echo '<th>ELO</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			echo '<tr>';
			echo '<td>'.$hockuser->getWins().'</td>';
			echo '<td>'.$hockuser->getLosses().'</td>';
			echo '<td>'.$hockuser->getStreak().'</td>';
			echo '<td>'.$hockuser->getSkill().'</td>';
			echo '</tr>';
			echo '</tbody>';
			echo '</table>';
			echo '</div>'; //end table
			echo '<h4>Bet Stats</h4>';
			echo '<div class="table">';
			echo '<table class="table" id="stats1">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Total</th>';
			echo '<th>Correct</th>';
			echo '<th>Incorrect</th>';
			echo '<th>Gain</th>';
			echo '<th>Cash</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			echo '<tr>';
			echo '<td>'.($hockuser->getWBets() + $hockuser->getLBets()).'</td>';
			echo '<td>'.$hockuser->getWBets().'</td>';
			echo '<td>'.$hockuser->getLBets().'</td>';
			echo '<td>'.$hockuser->getChanges().'</td>';
			echo '<td>$'.$hockuser->getWagerPoints().'</td>';
			echo '</tr>';
			echo '</tbody>';
			echo '</table>';
			echo '</div>'; //end table
			echo '</div>'; //end container
			
			
		} else
			echo "No stats to display for this non existent user";
?>
</section>
<section>
<?php 
		$allgames = (array_key_exists('allgames', $_SESSION))?$_SESSION['allgames']:null;
		if(!empty($allgames)){
			
			echo '<div class="container-fluid">';
			echo '<h4>Recent Games</h4>';
			echo '<div class="table-responsive">';
			echo '<table class="table" id="games">';
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
			foreach($allgames as $game){
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
				//Put all winning teams on left side of table
				$worth = GameController::calcWorth($game->getTeamSkill1(), $game->getTeamSkill2());
				$plusminus = 0;
				if(strcmp($game->getWinReports(), 'team1') == 0){
					//team1 won
					//team1
					$plusminus = $worth[0];
					$user1 = HockUserDB::getUsersBy('id', $team1->getUID1());
					$user2 = HockUserDB::getUsersBy('id', $team1->getUID2());
					$user3 = HockUserDB::getUsersBy('id', $team1->getUID3());
					//team2
					$user4 = HockUserDB::getUsersBy('id', $team2->getUID1());
					$user5 = HockUserDB::getUsersBy('id', $team2->getUID2());
					$user6 = HockUserDB::getUsersBy('id', $team2->getUID3());
					$winnerskill = $game->getTeamSkill1();
					$loserskill = $game->getTeamSkill2();
				} else {
					//team2 won
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
					$plusminus = $worth[1];
				}
					
				if(empty($user1) || empty($user2) || empty($user3) || empty($user4) || empty($user5) || empty($user6))
					break;
					
				$user1 = $user1[0];
				$user2 = $user2[0];
				$user3 = $user3[0];
				$user4 = $user4[0];
				$user5 = $user5[0];
				$user6 = $user6[0];
				
				$u1 = $u2 = $u3 = $u4 = $u5 = $u6 = "";
				switch ($arguments){
					case $user1->getUserName():
						$u1 = "user";
						break;
					case $user2->getUserName():
						$tmp = $user1;
						$user1 = $user2;
						$user2 = $tmp;
						$u1 = "user";
						break;
					case $user3->getUserName():
						$tmp = $user1;
						$user1 = $user3;
						$user3 = $tmp;
						$u1 = "user";
						break;
					case $user4->getUserName():
						$u4 = "user";
						break;
					case $user5->getUserName() :
						$tmp = $user4;
						$user4 = $user5;
						$user5 = $tmp;
						$u4 = "user";
						break;
					case $user6->getUserName() :
						$tmp = $user4;
						$user4 = $user6;
						$user6 = $tmp;
						$u4 = "user";
						break;
				}
					
				$start = new DateTime($game->getStart());
				$end = new DateTime($game->getEnd());
				
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
				echo '<td class="'.$user1->getHome().$u1.'"><a href="' . $base . '/user/show/' . $user1->getUserName() . '">'.$user1->getUserName().'</td>';
				echo '<td class="'.$user2->getHome().$u2.'"><a href="' . $base . '/user/show/' . $user2->getUserName() . '">'.$user2->getUserName().'</td>';
				echo '<td class="'.$user3->getHome().$u3.'"><a href="' . $base . '/user/show/' . $user3->getUserName() . '">'.$user3->getUserName().'</td>';
				echo '<td>'.$winnerskill.'</td>';
				echo '<td class="plus">+'.$plusminus.'</td>';
				echo '<td class="'.$user4->getHome().$u4.'"><a href="' . $base . '/user/show/' . $user4->getUserName() . '">'.$user4->getUserName().'</td>';
				echo '<td class="'.$user5->getHome().$u5.'"><a href="' . $base . '/user/show/' . $user5->getUserName() . '">'.$user5->getUserName().'</td>';
				echo '<td class="'.$user6->getHome().$u6.'"><a href="' . $base . '/user/show/' . $user6->getUserName() . '">'.$user6->getUserName().'</td>';
				echo '<td>'.$loserskill.'</td>';
				echo '<td class="minus">-'.$plusminus.'</td>';
				echo '<td>'.$timestr.'</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
			echo '</div>'; //end table
			echo '</div>'; //end container
		}
		
?>
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
  	
  	public static function showUpdateButton(){
  		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
  		$authenticatedUser = $_SESSION['authenticatedUser'];
  		echo '<a href="' . $base . '/user/update/' . $authenticatedUser->getUserName() .'" class="button">Update Profile</a>';
  	}
}
?>