<?php
class LoginController {
	private $formInput;
	
	public static function run() {
		$webuser = NULL;
		$hockuser = NULL;
		$user = NULL;
		
 		if ($_SERVER["REQUEST_METHOD"] == "POST") {
 			$user = new User($_POST);
 			$webusers = WebUserDB::getUsersBy('userName', $user->getUserName());
 			if (empty($webusers))
 				$user->setError('userName', 'USER_NAME_DOES_NOT_EXIST');
 			else
 				$webuser = $webusers[0];
 		}
 		
 		if(!is_null($webuser)){
 			if(strcmp($webuser->getPassword(), $user->getPassword()) == 0){
 				//passwords match.
 				//get associated hockuser
 				echo "<p>" . $webuser . "</p>";
 				$hockusers = HockUserDB::getUsersBy('name', $webuser->getHockName());
 				if(empty($hockusers))
 					$user->setError('userName', 'HOCK_NAME_UNASSOCIATED_WITH_ACCOUNT');
 				else
 					$hockuser = $hockusers[0];
 			}
 			else{
 				//Invalid password
 				$user->setError('password', 'PASSWORD_INVALID');
 			}
 		}
 			
 		$_SESSION['user'] = $webuser;
 		if (is_null($webuser) || $user->getErrorCount() != 0)
 			LoginView::show($user);
 		else  {
 			//show profile
 			//ProfileView::show($webuser, $hockuser);
 			//show home
 			HomeView::show();
 			header('Location: /'.$_SESSION['base']);
 		}
	}
}
?>
