<?php
//include ("Messages.class.php");
class User {
	private $errorCount;
	private $errors;
	private $formInput;
	
	
	private $name;
	private $skill;
	private $home;
	private $alias;
	private $color;
	private $wins;
	private $losses;
	private $gameid;
	private $teamid;
	private $aliaschanges;
	private $aliaspending;
	private $bads;
	private $streak;
	private $report;
	private $streakcolor;
	private $awayskill;
	private $goals;
	private $assists;
	private $owngoals;
	private $cap;
	private $wbets;
	private $lbets;
	private $changes;
	private $numge;
	private $gepoints;
	private $wager;
	private $wwager;
	private $lwager;
	private $wagerdiff;
	private $wagerpoints;
	
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
		return $this->name;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("userName" => $this->name); 
		return $paramArray;
	}

	public function __toString() {
		$str = "User name: ".$this->name;
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
		else{
		   $this->validateUserName();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->userName = "";
	}

	private function validateUserName() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->name = $this->extractForm('name');
		if (empty($this->userName)) 
			$this->setError('userName', 'USER_NAME_EMPTY');
		elseif (!filter_var($this->userName, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
			$this->setError('userName', 'USER_NAME_HAS_INVALID_CHARS');
		}
	}
	
	private function validateUserName() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->name = $this->extractForm('name');
		if (empty($this->userName))
			$this->setError('userName', 'USER_NAME_EMPTY');
	}
	
	
}
?>