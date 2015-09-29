<?php
class SignupController {

	public static function run() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$userdata = new UserData($_POST);
			if ($userdata->getErrorCount() == 0)
				SimpleEchoView::show();//HomeView::show();
			else
				SignupView::show($userdata);
		} else  // Initial link
			SignupView::show(null);
	 }
}
?>