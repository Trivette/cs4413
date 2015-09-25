<?php
	include("includer.php");
	
	$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	
	$urlPieces = split("/", $url);
	
	if(count($urlPieces) < 2)
		$control = "none";
	else 
		$control = $urlPieces[2];
	
	switch($control){
		case "login":
			LoginController::run();
			break;
		case "signup":
			SignupController::run();
			break;
		default:
			HomeView::show();
		
	}
?>