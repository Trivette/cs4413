<?php
//include ("Messages.class.php");
class Bet {
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $betAmount;
	private $game;
	private $time;
	
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
		return $this->betAmount;
	}
	
	public function getGame() {
		return $this->game;
	}
	
	public function getTime(){
		return $this->time;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("betAmount" => $this->betAmount, "game" => $this->game, "time" => $this->time); 
		return $paramArray;
	}

	public function __toString() {
		$str = "Bet Amount: ".$this->betAmount . " game: " . $this->game . " time: " . $this->time;
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
		   $this->time = time();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->betAmount = "";
	 	$this->game = "";
	 	$this->time = "";
	}

	private function validateBetAmount() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->betAmount = $this->extractForm('betAmount');
		if (empty($this->betAmount)) 
			$this->setError('betAmount', 'NO_BET');
		elseif (intval($this->betAmount) < 1 || intval($this->betAmount) > 10){
			$this->setError('betAmount', 'INVALID_BET');
		}
	}
	
	private function validateGame(){
		$this->game = $this->extractForm('game');
		if(empty($this->game))
			$this->setError('password', 'NO_GAME');
	}
}
?>