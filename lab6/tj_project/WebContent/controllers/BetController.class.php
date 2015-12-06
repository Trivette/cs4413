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
				//make sure authenticatedUser is set
				$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?$_SESSION['authenticatedUser']:null;
				if(is_null($authenticatedUser)){
					$bet->setError('user', 'USER_NOT_AUTH');
					BetView::show($bet);
					return;
				}
				$hockname = $authenticatedUser->getHockName();
				$bet->setUser(strtolower($hockname));
				//game exists check
				$games = GameDB::getGamesBy('id', $bet->getGameID());
				if(empty($games)){
					$bet->setError('game', 'NO_GAMEID');
					BetView::show($bet);
					return;
				}
				//user already has a bet check
				$game = $games[0];
				$bets = BetDB::getBetsBy('game', $game->getID());
				if(!empty($bets)){
					foreach($bets as $bet){
						if(strcmp($bet->getUser(), strtolower($hockname)) == 0){
							$bet->setError('game', 'BET_ALREADY');
							BetView::show($bet);
							return;
						}
					}
				}
				//pending check
				if($game->getPending() != 1){
					$bet->setError('game', 'GAME_NOT_PENDING');
					BetView::show($bet);
					return;
				}
				//game time check
				$start = new DateTime($game->getStart());
				$diff = $start->diff($bet->getTime());
				if($diff->m != 0 || $diff->d != 0 || $diff->h != 0 || $diff->i >= 5){
					$bet->setError('game', 'LATE_BET');
					BetView::show($bet);
					return;
				}
				//Should be ok to submit bet...
				$id = BetDB::addBet($bet);
				$bet->setBetID($id);
				BetView::show($bet);
				//SimpleEchoView::show($bet);
			}
			else
				BetView::show($bet);
		} else  // Initial link
			BetView::show(null);
	}
}
?>
