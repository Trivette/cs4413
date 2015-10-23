<?php
class LoginController {
	public static function run() {
 		if ($_SERVER["REQUEST_METHOD"] == "POST") {
 			$webuser = WebUserDB::getUsersBy('name');
 			$webuser = new WebUser($_POST);
 			if ($webuser->getErrorCount() == 0) 
 				HomeView::show();
 		    else
 				LoginView::show($webuser);
 		} else  // Initial link
			LoginView::show(null);
	}
}
?>
