<?php
include ("Messages.class.php");
class UserData {
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $userName;
	private $email;
	private $password;
	private $confirmedpw;
	private $dob;
	private $gender;
	private $url;
	private $picture;
	private $hockUser;
	private $color;
	
	public function __construct($formInput = null) {
		$this->formInput = $formInput;
		Messages::reset();
		$this->initialize();
	}

	public function getError($errorName) {
		if (isset($this->errors[$errorName]))
			return $this->errors[$errorName];
		else
			return "";
	}

	public function setError($errorName, $errorValue) {
		// Sets a particular error value and increments error count
		$this->errors[$errorName] =  Messages::getError($errorValue);
		$this->errorCount ++;
	}

	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getUserName() {
		return $this->userName;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getDOB() {
		return $this->dob;
	}
	
	public function getURL(){
		return $this->url;
	}
	
	public function getGender(){
		return $this->gender;
	}
	
	public function getColor(){
		return $this->color;
	}
	
	public function getHockUser(){
		return $this->hockUser;
	}
	
	public function getPicture(){
		return $this->picture;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("userName" => $this->userName, "password" => $this->password, "confirmedpw" => $this->confirmedpw, 
				"email" => $this->email, "dob" => $this->dob, "color" => $this->color, "gender" => $this->gender, "hockUser" => $this->hockUser,
				"picture" => $this->picture, "url" => $this->url
		); 
		return $paramArray;
	}

	public function __toString() {
		$str = "User name: ".$this->userName;
		return $str;
	}
	
	private function extractForm($valueName) {
		// Extract a stripped value from the form array
		$value = "";
		if (isset($this->formInput[$valueName])) {
			$value = trim($this->formInput[$valueName]);
			$value = stripslashes ($value);
			$value = htmlspecialchars ($value);
			return $value;
		}
	}
	
	private function initialize() {
		$this->errorCount = 0;
		$errors = array();
		if (is_null($this->formInput))
			$this->initializeEmpty();
		else {
		   $this->validateUserName();
		   $this->validatePassword();
		   $this->validateConfirmedPassword();
		   $this->validateEmail();
		   $this->validateDOB();
		   $this->validatePicture();
		   $this->url = $this->extractForm('url');
		   $this->validateGender();
		   $this->color = $this->extractForm('color');
		   $this->validateHockUser();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->userName = "";
	 	$this->email = "";
	 	$this->password = "";
	 	$this->confirmedpw = "";
	 	$this->gender = "";
	 	$this->dob = "";
	 	$this->url = "";
	 	$this->picture = "";
	 	$this->hockUser = "";
	 	$this->color = "#000000";
	}

	private function validateUserName() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->userName = $this->extractForm('userName');
		if (empty($this->userName)) 
			$this->setError('userName', 'USER_NAME_EMPTY');
		elseif (!filter_var($this->userName, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
			$this->setError('userName', 'USER_NAME_HAS_INVALID_CHARS');
		}
	}
	
	private function validatePassword() {
		//Password requires 1 Capital 1 Lowercase and 1 number and 8 characters long
		$this->password = $this->extractForm('password');
		$r1 = '/[A-Z]/'; //Uppercase
		$r2 = '/[a-z]/'; //lowercase
		$r3 = '/[0-9]/'; //number
		if(empty($this->password))
			$this->setError('password', 'PASSWORD_EMPTY');
		elseif(preg_match_all($r1,$this->password, $o)<1)
			$this->setError('password', 'PASSWORD_REQUIREMENTS');
		elseif(preg_match_all($r2,$this->password, $o)<1)
			$this->setError('password', 'PASSWORD_REQUIREMENTS');
		elseif(preg_match_all($r3,$this->password, $o)<1)
			$this->setError('password', 'PASSWORD_REQUIREMENTS');
		elseif(strlen($this->password)<8)
			$this->setError('password', 'PASSWORD_REQUIREMENTS');
	}
	
	private function validateConfirmedPassword(){
		$this->confirmedpw = $this->extractForm('confirmedpw');
		if($this->confirmedpw != $this->password)
			$this->setError('confirmedpw', 'PASSWORD_MISMATCH');
	}
	
	private function validateHockUser(){
		//Valid hockUser will be forced by htlm5, this is just an empty check
		$this->hockUser = $this->extractForm('hockUser');
		if(empty($this->hockUser))
			$this->setError('hockUser', 'HOCKUSER_EMPTY');
	}
	
	private function validatePicture(){
		$this->picture = $this->extractForm('picture');
		if(empty($this->picture))
			$this->setError('picture', 'NO_PICTURE');
	}
	
	private function validateGender(){
		//Valid gender will be forced by htlm5, this is just an empty check
		$this->gender = $this->extractForm('gender');
		if(empty($this->gender))
			$this->setError('gender', 'NO_GENDER');
	}
	
	private function validateDOB(){
		//Validate user is 13 or older
		$this->dob = $this->extractForm('dob');
		if(empty($this->dob))
			$this->setError('dob', 'NO_DOB');
		else{
			$dobarray = explode("-", $this->dob);
			$year = intval($dobarray[0]);
			$month = intval($dobarray[1]);
			$day = intval($dobarray[2]);
			//2015-13 = 2002. Enter anything less than that, that's an error.
			if($year > intval(date("Y")) - 13)
				$this->setError("dob", "DOB_ERROR");
			//If year is equiv, but month is less than current month, user is still 12
			elseif($year == intval(date("Y")) - 13 && $month < intval(date("m")))
				$this->setError("dob", "DOB_ERROR");
			//If year and month are equiv, but day is less than current day, user is still 12
			elseif($year == intval(date("Y")) - 13 && $month == intval(date("m")) && $day < intval(date("d")))
				$this->setError("dob", "DOB_ERROR");
		}
	}
	
	private function validateEmail(){
		//Valid emails will be forced by html5, this is just an empty check
		$this->email = $this->extractForm('email');
		if(empty($this->email))
			$this->setError('email', 'NO_EMAIL');
	}
}
?>