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
			default:
				//Find the specified user
				$hockusers = HockUserDB::getUsersBy('name', $action);
				if(is_null($hockusers)){
					$hockusers = HockUserDB::getUsersBy('alias', $action);
					if(is_null($hockusers))
						$hockuser=null;
					else 
						$hockuser = $hockusers[0];
				}
				else 
					$hockuser = $hockusers[0];
				UserController::show($hockuser);
		}
	}
	
	public static function show($hockuser) {
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		if (!is_null($hockuser)) {
		    ProfileView::show(null, $hockuser);
		} else
			ProfileView::show(null, null);
	}
}
?>