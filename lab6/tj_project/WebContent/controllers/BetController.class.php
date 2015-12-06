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
				//game exists check
				$games = GameDB::getGamesBy('id', $bet->getGameID());
				if(empty($games)){
					$bet->setError('gameID', 'NO_GAMEID');
					BetView::show($bet);
					return;
				}
				//pending check
				$game = $games[0];
				if($game->getPending() != 1){
					$bet->setError('gameID', 'GAME_NOT_PENDING');
					BetView::show($bet);
					return;
				}
				//game time check
				$start = new DateTime($game->getStart());
				$diff = $start->diff($bet->getTime());
				if($diff->m != 0 || $diff->d != 0 || $diff->h != 0 || $diff->m > 5){
					$bet->setError('gameID', 'LATE_BET');
					BetView::show($bet);
					return;
				}
				//Should be ok to submit bet...
				SimpleEchoView::show($bet);
			}
			else
				BetView::show($bet);
		} else  // Initial link
			BetView::show(null);
	}
}
?>
