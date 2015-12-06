<?php
class GameController {
	public static function run() {
		$action = (array_key_exists('action', $_SESSION))?$_SESSION['action']:"";
		$arguments = $_SESSION['arguments'];
		switch ($action) {
			case "all":
				$_SESSION['games'] = GameDB::getAllGames();
				GameView::showAll();
				break;
			default:
		}
	}
	/*
	 * This function will generate a new game randomly.
	 * It will create 2 teams of 3 randomly selected users
	 * It will add their skill together and put the current time as start time.
	 * It will make sure not to pick users who are already in a pending game
	 */
	public static function generateNewGame(){
		$users = HockUserDB::getAllUsersNotInGame();
		if(empty($users)) return;
		if(count($users) < 6){
			echo "<p>Error getting enough users not in a game... " . $e->getMessage () . "</p>";
			return;
		}
		
		//get random users for game
		shuffle($users);
		$user1 = array_pop($users);
		$user2 = array_pop($users);
		$user3 = array_pop($users);
		$user4 = array_pop($users);
		$user5 = array_pop($users);
		$user6 = array_pop($users);
		
		$users1 = array($user1, $user2, $user3);
		$users2 = array($user4, $user5, $user6);
		if(empty($users1)){
			echo '<p>Error getting users1</p>';
			return;
		}
		if(empty($users2)){
			echo '<p>Error getting users2</p>';
			return;
		}
		//calculate each team's skill
		$skill1 = $user1->getSkill() + $user2->getSkill() + $user3->getSkill();
		$skill2 = $user4->getSkill() + $user5->getSkill() + $user6->getSkill();
		
		//create new game
		$game = new Game();
		$gameparms = $game->getParameters();
		$gameparms['teamskill1'] = $skill1;
		$gameparms['teamskill2'] = $skill2;
		$gameparms['pending'] = 1;
		$gameparms['start'] = date("Y-m-d H:i:s");
		$gameparms['type'] = 'random';
		$gameparms['server'] = 1;
		$game = new Game($gameparms);
		$gameid = GameDB::addGame($game);
		$game->setGameId($gameid);
		
		//create team1 
		$team1 = new Team();
		$parms = $team1->getParameters();
		$parms['uid1'] = $user1->getUserId();
		$parms['uid2'] = $user2->getUserId();
		$parms['uid3'] = $user3->getUserId();
		$parms['gameId'] = $game->getID();
		$team1 = new Team($parms);
		$teamid1 = TeamDB::addTeam($team1);
		$team1->setteamId($teamid1);
		
		//create team2
		$team2 = new Team();
		$parms = $team2->getParameters();
		$parms['uid1'] = $user4->getUserId();
		$parms['uid2'] = $user5->getUserId();
		$parms['uid3'] = $user6->getUserId();
		$parms['gameId'] = $game->getID();
		$team2 = new Team($parms);
		$teamid2 = TeamDB::addTeam($team2);
		$team2->setteamId($teamid2);
		
		//update game with teamid's
		$game->setTeamId1($team1->getteamId());
		$game->setTeamId2($team2->getteamId());
		
		$gameupdate = GameDB::updateGame($game);
		
		//update users to show they are in game
		foreach($users1 as $user){
			$user->setGameId($game->getID());
			$user->setTeamId($team1->getteamId());
			HockUserDB::updateUser($user);
		}
		
		foreach($users2 as $user){
			$user->setGameId($game->getID());
			$user->setTeamId($team1->getteamId());
			HockUserDB::updateUser($user);
		}
		
		//Game and teams created and users update...  Done!
		
	}
	
	public static function calcWorth($team1, $team2){
		if ($team1 < $team2){
			$dif = $team2-$team1;
			if($dif <= 25)
				return array(10, 10);
			elseif ($dif <= 50)
				return array(11, 9);
			elseif ($dif <= 75)
				return array(12, 9);
			elseif ($dif <= 100)
				return array(13, 8);
			elseif ($dif <= 125)
				return array(14, 8);
			elseif ($dif <= 150)
				return array(15, 7);
			elseif ($dif <= 175)
				return array(16, 7);
			elseif ($dif <= 200)
				return array(17, 6);
			else
				return array(18, 6);
		} else {
			$dif = $team1-$team2;
			if($dif <= 25)
				return array(10, 10);
			elseif ($dif <= 50)
				return array(9, 11);
			elseif ($dif <= 75)
				return array(9, 12);
			elseif ($dif <= 100)
				return array(8, 13);
			elseif ($dif <= 125)
				return array(8, 14);
			elseif ($dif <= 150)
				return array(7, 15);
			elseif ($dif <= 175)
				return array(7, 16);
			elseif ($dif <= 200)
				return array(6, 17);
			else
				return array(6, 18);
		}
	}
	
	
}
?>