<?php
//include ("Messages.class.php");
class Bet {
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $amount;
	private $game;
	private $time;
	private $id;
	private $user;
	private $team;
	
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

	public function getBetAmount() {
		return $this->amount;
	}
	
	public function getGameID() {
		return $this->game;
	}
	
	public function getTime(){
		return $this->time;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("amount" => $this->amount, "game" => $this->game, "time" => $this->time); 
		return $paramArray;
	}

	public function __toString() {
		$str = "Bet Amount: ".$this->amount . " game: " . $this->game . " time: " . $this->time->format("Y-m-d H:i:s");
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
		   $this->validateBetAmount();
		   $this->validateGame();
		   $this->time = new DateTime(date("Y-m-d H:i:s"));
		   $this->user = $this->extractForm('who');
		   $this->validateTeam();
		   $this->id = $this->extractForm('id');
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->amount = "";
	 	$this->game = "";
	 	$this->time = "";
	 	$this->team = "";
	 	$this->user = "";
	}

	private function validateBetAmount() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->amount = $this->extractForm('wager');
		if (empty($this->amount)) 
			$this->setError('amount', 'NO_BET');
		elseif (intval($this->amount) < 1 || intval($this->amount) > 10){
			$this->setError('amount', 'INVALID_BET');
		}
	}
	
	private function validateGame(){
		$this->game = $this->extractForm('game');
		if(empty($this->game))
			$this->setError('gameID', 'NO_GAME');
	}
	
	private function validateTeam(){
		$this->team = $this->extractForm('team');
		if(empty($this->team))
			$this->setError('team', 'NO_TEAM');
		elseif($this->team != 'team1' && $this->team != 'team2')
			$this->setError('team', 'INVALID_TEAM');
	}
}
?>