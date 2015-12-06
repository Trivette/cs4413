<?php
class BetController {
	public static function run() {
		// Perform actions related to Betting
		$action = (array_key_exists('action', $_SESSION))?$_SESSION['action']:"";
		$arguments = $_SESSION['arguments'];
		switch ($action) {
			case "generate":
				GameController::generateNewGame();
				BetView::showGames();
				break;
			default:
				BetController::show();
		}
	}
	
	public static function show(){
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$bet = new Bet($_POST);
			if ($bet->getErrorCount() == 0){
				$games = GameDB::getGamesBy('id', $bet->getGameID());
				if(empty($games)){
					$bet->setError('gameID', 'NO_GAMEID');
					BetView::show($bet);
				} else {
					SimpleEchoView::show($bet);
				}
			}
			else
				BetView::show($bet);
		} else  // Initial link
			BetView::show(null);
	}
}
?>
