<?php
class SignupController {

	public static function run() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			HomeView::show();
		} else  // Initial link
			SignupView::show();
	 }
}
?>