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