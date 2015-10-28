<?php
    ob_start();
	include("includer.php"); 

	//session_start();
	$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	list($fill, $base, $control, $action, $arguments) =
			explode('/', $url, 5) + array("", "", "", "", null);
	 $_SESSION['base'] = $base;
	 $_SESSION['control'] = $control; 
	 $_SESSION['action'] = $action;
	 $_SESSION['arguments'] = $arguments;
	     
	switch ($control) {
		case "login" :
			LoginController::run ();
			break;
		case "bet" :
			BetController::run ();
			break;
		case "signup" :
			SignupController::run ();
			break;
		case "user" :
			UserController::run ();
			break;
		default:
			HomeView::show(null);		
	};
	ob_end_flush();
	
?>	
