<?php
class Game {
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $gameId;
	private $teamid1;
	private $teamid2;
	private $pending;
	private $teamskill1;
	private $teamskill2;
	private $winreports;
	private $losereports;
	private $server;
	private $start;
	private $end;
	private $type;

	
	public function __construct($formInput = null) {
		$this->formInput = $formInput;
		Messages::reset();
		$this->initialize();
	}

	public function getError($errorName) {
		// Return the error string associated with $errorName
		if (isset($this->errors[$errorName]))
			return $this->errors[$errorName];
		else
			return "";
	}


	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}
	
	public function getID() {
		return $this->gameId;
	}
	
	public function getTeamID1() {
		return $this->teamid1;
	}

	public function getTeamID2() {
		return $this->teamid2;
	}
	
	public function getPending(){
		return $this->pending;
	}
	
	public function getTeamSkill1(){
		return $this->teamskill1;
	}
	
	public function getTeamSkill2(){
		return $this->teamskill2;
	}
	
	public function getWinReports(){
		return $this->winreports;
	}
	
	public function getLoseReports(){
		return $this->losereports;
	}
	
	public function getServer(){
		return $this->server;
	}
	
	public function getStart(){
		return $this->start;
	}
	
	public function getEnd(){
		return $this->end;
	}
	
	public function getType(){
		return $this->type;
	}
	

	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("userName" => $this->userName,
				            "password" => $this->password,
				            "userId" => $this->userId
		); 
		return $paramArray;
	}
	
	public function setError($errorName, $errorValue) {
		// Set a particular error value and increments error count
		if (!array_key_exists($errorName, $this->errors)) {
			$this->errors[$errorName] =  Messages::getError($errorValue);
			$this->errorCount ++;
		}
	}
	
	public function setGameId($id) {
		// Set the value of the userId to $id
		$this->gameId = $id;
	}

	public function __toString() {
		$errorStr = "";
		foreach($this->errors as $error)
			$errorStr = $errorStr . " ". $error;
		$str = "User name: ".$this->userName."<br>Password: ".$this->password . 
		       "<br>User id: ". $this->userId.
		        "<br>Errors:  $errorStr<br>";
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
		$this->errors = array();
		if (is_null($this->formInput)) {
			$this->initializeEmpty();
		} else  {	 
			$this->gameId = $this->extractForm('id');
			$this->teamid1 = $this->extractForm('teamid1');
			$this->teamid2 = $this->extractForm('teamid2');
			$this->pending = $this->extractForm('pending');
			$this->teamskill1 =$this->extractForm('teamskill1');
			$this->teamskill2 = $this->extractForm('teamskill2');
			$this->winreports = $this->extractForm('winreports');
			$this->losereports = $this->extractForm('losereports');
			$this->server = $this->extractForm('server');
			$this->start = $this->extractForm('start');
			$this->end = $this->extractForm('end');
			$this->type = $this->extractForm('type');
		}
	}
	
	private function initializeEmpty() {
		$this->teamid1 = 0;
		$this->teamid2 = 0;
		$this->pending = 0;
		$this->teamskill1 = 0;
		$this->teamskill2 = 0;
		$this->winreports = '';
		$this->losereports = '';
		$this->server = 0;
		$this->start = 0;
		$this->end = 0;
		$this->type ='';
	}
}
?>