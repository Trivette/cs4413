<?php
class SignupController {

	public static function run() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$webuser = new WebUser($_POST);
			if ($webuser->getErrorCount() == 0){
				//create a webuser in db
				$id = WebUserDB::addUser($webuser);
				if($id != 0){
					//find the hockuser related to this dude
					$hockuser = HockUserDB::getUserBy('name', $webuser->getUserName());
					ProfileView::show($webuser, $hockuser);//HomeView::show();
				}
				else{
					$webuser->setError('userName', 'DBERROR_ADDWEBUSER');
					SignupView::show($webuser);
				}
			}
			else
				SignupView::show($webuser);
		} else  // Initial link
			SignupView::show(null);
	 }
}
?>