<?php
class SignupController {

	public static function run() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$webuser = new WebUser($_POST);
			if ($webuser->getErrorCount() == 0)
				ProfileView::show($webuser);//HomeView::show();
			else
				SignupView::show($webuser);
		} else  // Initial link
			SignupView::show(null);
	 }
}
?>