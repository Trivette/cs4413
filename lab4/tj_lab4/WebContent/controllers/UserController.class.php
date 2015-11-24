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
		$users = UsersDB::getUsersBy('userId', $_SESSION['arguments']);
		if (empty($users)) {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['user'] = $users[0];
			UserView::showUpdate();
		} else {
			$parms = $users[0]->getParameters();
			$parms['userName'] = (array_key_exists('userName', $_POST))?
			$_POST['userName']:"";
			$parms['password'] = (array_key_exists('password', $_POST))?
			$_POST['password']:"";
			$user = new User($parms);
			$user->setUserId($users[0]->getUserId());
			$user = UsersDB::updateUser($user);
	
			if ($user->getErrorCount() != 0) {
				$_SESSION['user'] = $user;
				UserView::showUpdate();
			} else {
				HomeView::show();
				header('Location: /'.$_SESSION['base']);
			}
		}
	}
}
?>