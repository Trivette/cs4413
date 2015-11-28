<?php
class Team {
	private $errorCount;
	private $errors;
	private $formInput;
	
	
	private $teamId;
	private $uid1;
	private $uid2;
	private $uid3;
	private $gameId;

	
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
	
	public function getGameId() {
		return $this->gameId;
	}
	
	public function getteamId() {
		return $this->teamId;
	}

	public function getUID1() {
		return $this->uid1;
	}
	
	public function getUID2() {
		return $this->uid2;
	}
	
	public function getUID3() {
		return $this->uid3;
	}
	

	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("teamId" => $this->teamId,
				            "gameId" => $this->gameId,
				            "uid1" => $this->uid1,
							"uid1" => $this->uid2,
							"uid1" => $this->uid3
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
	
	public function setteamId($id) {
		// Set the value of the teamId to $id
		$this->teamId = $id;
	}

	public function __toString() {
		$errorStr = "";
		foreach($this->errors as $error)
			$errorStr = $errorStr . " ". $error;
		$str = "Team ID: ".$this->teamId."<br>Game ID: ".$this->gameId . 
		       "<br>User ids: ". $this->uid1 . ', '. $this->uid2 . ', ' . $this->uid3 .
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
			$this->gameId = 0;
	 	    $this->uid1 = 0;
	 	    $this->uid2 = 0;
	 	    $this->uid3 = 0;
		} else  {	 
		   $this->validateGameId();
		   $this->validateUIDs();
		}
	}

	private function validateGameId() {
		
		$this->gameId = $this->extractForm('gameId');
		if (empty($this->gameId)) 
			$this->setError('gameId', 'NO_GAMEID');
	}
	
	private function validateUIDs() {
		
		$this->uid1 = $this->extractForm('uid1');
		if (empty($this->uid1))
			$this->setError('uid1', 'USER_ID1_ERROR');
		
		$this->uid2 = $this->extractForm('uid2');
		if (empty($this->uid2))
			$this->setError('uid2', 'USER_ID2_ERROR');
		
		$this->uid3 = $this->extractForm('uid3');
		if (empty($this->uid3))
			$this->setError('uid3', 'USER_ID3_ERROR');
	}
}
?>