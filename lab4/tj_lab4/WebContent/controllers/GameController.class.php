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
}
?>