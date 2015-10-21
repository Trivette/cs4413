<?php
class BetController {
	public static function run() {
 		if ($_SERVER["REQUEST_METHOD"] == "POST") {
 			$bet = new Bet($_POST);
 			if ($bet->getErrorCount() == 0) 
 				SimpleEchoView::show($bet);
 		    else
 				BetView::show($bet);
 		} else  // Initial link
			BetView::show(null);
	}
}
?>
