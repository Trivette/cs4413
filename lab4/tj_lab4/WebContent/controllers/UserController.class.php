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
		    ProfileView::show($webuser, $hockuser);
		} else
			ProfileView::show(null, null);
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
			if(!is_null($authenticatedUser)){
				if(strcmp($user->getUserName(), $authenticatedUser->getUserName()) == 0){
					//$oldpw = (array_key_exists('oldPassword', $_POST))?$_POST['oldPassword']:null;
					$parms = $users[0]->getParameters();
					//if(is_null($oldpw) || strcmp($oldpw, $parms['password'])
					$parms['userName'] = (array_key_exists('userName', $_POST))?$_POST['userName']:$authenticatedUser->getUserName();
					$parms['password'] = (array_key_exists('password', $_POST))?$_POST['password']:$authenticatedUser->getPassword();
					$parms['confirmedpw'] = (array_key_exists('confirmedpw', $_POST))?$_POST['confirmedpw']:$authenticatedUser->getConfirmedPW();
					$parms['email'] = (array_key_exists('email', $_POST))?$_POST['email']:$authenticatedUser->getEmail();
					$parms['url'] = (array_key_exists('url', $_POST))?$_POST['url']:$authenticatedUser->getURL();
					$user = new WebUser($parms);
					$user->setUserId($users[0]->getUserId());
					$user = WebUsersDB::updateUser($user);
					
					if ($user->getErrorCount() != 0) {
						$_SESSION['webuser'] = $user;
						UserView::showUpdate();
					} else {
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
}
?>