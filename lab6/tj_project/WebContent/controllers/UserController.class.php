<?php
class UserController {

	public static function run() {
		// Perform actions related to a user
		$action = (array_key_exists('action', $_SESSION))?$_SESSION['action']:"";
		$arguments = $_SESSION['arguments'];
		switch ($action) {
			case "leaderboard":
				$_SESSION['users'] = HockUserDB::getAllUsers();
				$_SESSION['headertitle'] = "Hock League Leaderboard";
				UserView::showall();
				break;
			case "show":
				self::show();
				break;
			case "update":
				self::updateUser();
				break;
			default:
		}
	}
	
	public static function show() {
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		$hockusers = HockUserDB::getUsersBy('name', $arguments);
		$hockuser = (!empty($hockusers))?$hockusers[0]:null;
		$webuser = null;
		if(is_null($hockuser)){
			$hockusers = HockUserDB::getUsersBy('alias', $arguments);
			$hockuser = (!empty($hockusers))?$hockusers[0]:null;
		}
		
		if(!is_null($hockuser)){
			$webusers = WebUserDB::getUsersBy('hockName', $hockuser->getUserName());
			if(!empty($webusers))
				$webuser = $webusers[0];
		}
		
		if (!is_null($hockuser)) {
			$teams1 = TeamDB::getTeamsBy('uid1', $hockuser->getUserId());
			$teams2 = TeamDB::getTeamsBy('uid2', $hockuser->getUserId());
			$teams3 = TeamDB::getTeamsBy('uid3', $hockuser->getUserId());
			$allteams = array_merge($teams1, $teams2, $teams3);
			if(!is_null($allteams)){
				$allgames = array();
				foreach($allteams as $team){
					$game = GameDB::getGamesBy('teamid1', $team->getteamId());
					$game2 = GameDB::getGamesBy('teamid2', $team->getteamId());
					if(!empty($game))
						array_push($allgames, $game[0]);
					if(!empty($game2))
						array_push($allgames, $game2[0]);
				}
				if(empty($allgames)){
					echo '<p>All games is empty</p>';
					$_SESSION['allgames'] = null;
				}
				else{
					usort($allgames, "UserController::cmp");
					$_SESSION['allgames'] = $allgames;
				}
			}
		    ProfileView::show($webuser, $hockuser);
		} else{
			$_SESSION['allgames'] = null;
			ProfileView::show(null, null);
		}
	}
	
	public static function updateUser() {
		// Process updating of user information
		$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?$_SESSION['authenticatedUser']:null;
		$users = WebUserDB::getUsersBy('hockName', $_SESSION['arguments']);
		if (empty($users)) {
			UserController::showHome();
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['webuser'] = $users[0];
			$user = $users[0];
			if(!is_null($authenticatedUser)){
				if(strcmp($user->getUserName(), $authenticatedUser->getUserName()) == 0){
					UserView::showUpdate();
				} else {
					UserController::showHome();
				}
			} else {
				UserController::showHome();
			}
		} else {
			$user = $_SESSION['webuser'];
			if(!is_null($authenticatedUser)){
				if(strcmp($user->getUserName(), $authenticatedUser->getUserName()) == 0){
					//$oldpw = (array_key_exists('oldPassword', $_POST))?$_POST['oldPassword']:null;
					$parms = $users[0]->getParameters();
					//if(is_null($oldpw) || strcmp($oldpw, $parms['password'])
					//This is set up so that any empty parameters in update will be ignored.  
					//Only things entered will actually be updated
					//username
					$parms['userName'] = (array_key_exists('userName', $_POST))?
						(empty($_POST['userName']))?$authenticatedUser->getUserName():$_POST['userName']
						:$authenticatedUser->getUserName();
					//password
					$parms['password'] = (array_key_exists('password', $_POST))?
						(empty($_POST['password']))?$authenticatedUser->getPassword():$_POST['password']
						:$authenticatedUser->getPassword();
					//confirmedpw
					$parms['confirmedpw'] = (array_key_exists('confirmedpw', $_POST))?
						(empty($_POST['confirmedpw']))?$authenticatedUser->getConfirmedPW():$_POST['confirmedpw']
						:$authenticatedUser->getConfirmedPW();
					//email
					$parms['email'] = (array_key_exists('email', $_POST))?
						(empty($_POST['email']))?$authenticatedUser->getEmail():$_POST['email']
						:$authenticatedUser->getEmail();
					//url
					$parms['url'] = (array_key_exists('url', $_POST))?
						(empty($_POST['url']))?$authenticatedUser->getURL():$_POST['url']
						:$authenticatedUser->getURL();
					
					$user = new WebUser($parms);
					$user->setUserId($users[0]->getUserId());
					$user = WebUserDB::updateUser($user);
					
					if ($user->getErrorCount() != 0) {
						$_SESSION['webuser'] = $user;
						UserView::showUpdate();
					} else {
						$_SESSION['authenticatedUser'] = $user;
						UserController::showHome();
					}
				} else
					UserController::showHome();
			} else
				UserController::showHome();
		}
	}
	
	public static function showHome() {
		HomeView::show();
		header('Location: /'.$_SESSION['base']);
	}
	
	private static function cmp($a, $b){
		return strcmp($b->getID(), $a->getID());
	}
}
?>