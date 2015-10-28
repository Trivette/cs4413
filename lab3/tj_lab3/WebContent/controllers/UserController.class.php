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
				$webuser = null;
				$hockusers = HockUserDB::getUsersBy('name', $action);
				if(empty($hockusers)){
					$hockusers = HockUserDB::getUsersBy('alias', $action);
					if(empty($hockusers))
						$hockuser=null;
					else 
						$hockuser = $hockusers[0];
				}
				else 
					$hockuser = $hockusers[0];
				
				if(!is_null($hockuser)){
					//Find webuser associated with hockuser?
					$webusers = WebUserDB::getUsersBy('hockName', $hockuser->getUserName());
					if(!empty($webusers))
						$webuser = $webusers[0];
				}
				$_SESSION['hockuser'] = $hockuser;
				$_SESSION['webuser'] = $webuser;
				UserController::show();
		}
	}
	
	public static function show() {
		$hockuser = $_SESSION['hockuser'];
		$webuser = $_SESSION['webuser'];
		$arguments = (array_key_exists('arguments', $_SESSION))?$_SESSION['arguments']:0;
		if (!is_null($hockuser)) {
		    ProfileView::show($webuser, $hockuser);
		} else
			ProfileView::show(null, null);
	}
}
?>