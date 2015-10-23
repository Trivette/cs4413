<?php
class SignupController {

	public static function run() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$webuser = new WebUser($_POST);
			if ($webuser->getErrorCount() == 0){
				if(!empty(WebUserDB::getUsersBy('hockName', $webuser->getHockName()))){
					$webuser->setError('hockName', 'HOCKUSER_NAMECLAIMED');
					SignupView::show($webuser);
				}else {
					//create a webuser in db
					$id = WebUserDB::addUser($webuser);
					if($id != 0){
						//find the hockuser related to this dude
						$hockusers = HockUserDB::getUsersBy('name', $webuser->getHockUser());
						ProfileView::show($webuser, $hockusers[0]);//HomeView::show();
					}
					else{
						$webuser->setError('userName', 'DBERROR_ADDWEBUSER');
						SignupView::show($webuser);
					}
				}
			}
			else
				SignupView::show($webuser);
		} else  // Initial link
			SignupView::show(null);
	 }
}
?>