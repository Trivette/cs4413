<?php
//include ("Messages.class.php");
class HockUser {
	private $errorCount;
	private $errors;
	private $formInput;
	
	private $id;
	private $name;
	private $skill;
	private $home;
	private $alias;
	//private $color;
	private $wins;
	private $losses;
	private $gameid;
	private $teamid;
	private $aliaschanges;
	private $aliaspending;
	private $bads;
	private $streak;
	private $report;
	//private $streakcolor;
	//private $awayskill;
	private $goals;
	private $assists;
	private $owngoals;
	//private $cap;
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
	
	public function getUserId(){
		return $id;
	}
	
	public function getUserName() {
		return $this->name;
	}
	
	public function getSkill(){
		return $this->skill;
	}
	
	public function getHome(){
		return $this->home;
	}
	
	public function getAlias(){
		return $this->alias;
	}
	
	//public function getColor(){
	//	return $this->color;
	//}
	
	public function getWins(){
		return $this->wins;
	}
	
	public function getLosses(){
		return $this->losses;
	}
	
	public function getGameID(){
		return $this->gameid;
	}
	
	public function getTeamID(){
		return $this->teamid;
	}
	
	public function getAliasChanges(){
		return $this->aliaschanges;
	}
	
	public function getAliasPending(){
		return $this->aliaspending;
	}
	
	public function getBads(){
		return $this->bads;
	}
	
	public function getStreak(){
		return $this->streak;
	}
	//streakcolor, awayskill
	
	public function getGoals(){
		return $this->goals;
	}
	
	public function getAssists(){
		return $this->assists;	
	}
	
	public function getOwnGoals(){
		return $this->owngoals;
	}
	//cap
	
	public function getWBets(){
		return $this->wbets;
	}
	
	public function getLBets(){
		return $this->lbets;
	}
	
	public function getChanges(){
		return $this->changes;
	}
	
	public function getNumGE(){
		return $this->numge;
	}
	
	public function getWager(){
		return $this->wager;
	}
	
	public function getWWager(){
		return $this->wwager;
	}
	
	public function getLWager(){
		return $this->lwager;
	}
	
	public function getWagerDif(){
		return $this->wagerdif;
	}
	
	public function getWagerPoints(){
		return $this->wagerpoints;
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
			$this->id = $this->extractForm('id');
		   	$this->validateUserName();
		  	$this->validateSkill();
	   		$this->home = $this->extractForm('home');
		   	$this->alias = $this->extractForm('alias');
		   	$this->wins = $this->extractForm('wins');
		  	$this->losses = $this->extractForm('losses');
		   	$this->gameid = $this->extractForm('gameid');
		   	$this->teamid = $this->extractForm('teamid');
		   	$this->aliaschanges = $this->extractForm('aliaschanges');
		   	$this->aliaspending = $this->extractForm('aliaspending');
		   	$this->bads = $this->extractForm('bads');
		   	$this->streak = $this->extractForm('streak');
		   	$this->goals = $this->extractForm('goals');
		   	$this->assists = $this->extractForm('assists');
		   	$this->owngoals = $this->extractForm('owngoals');
		   	$this->wbets = $this->extractForm('wbets');
		   	$this->lbets = $this->extractForm('lbets');
		   	$this->changes = $this->extractForm('changes');
		   	$this->numge = $this->extractForm('numge');
		   	$this->wager = $this->extractForm('wager');
		   	$this->wwager = $this->extractForm('wwager');
		   	$this->lwager = $this->extractForm('lwager');
		   	$this->wagerdif = $this->extractForm('wagerdif');
		   	$this->wagerpoints = $this->extractForm('wagerpoints');
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
		$this->id = 0;
	 	$this->name = "";
	 	$this->skill = 1500;
		$this->home = 'null';
		$this->alias = '';
		//$this->color;
		$this->wins = 0;
		$this->losses = 0;
		$this->gameid = 0;
		$this->teamid = 0;
		$this->aliaschanges = 0;
		$this->aliaspending = '';
		$this->bads = 0;
		$this->streak = 0;
		$this->goals = 0;
		$this->assists = 0;
		$this->owngoals = 0;
		$this->wbets = 0;
		$this->lbets = 0;
		$this->changes = 0;
		$this->numge = 0;
		$this->wager = 0;
		$this->wwager = 0;
		$this->lwager = 0;
		$this->wagerdif = 0;
		$this->wagerpoints = 0;
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
	
	//This is pulled from a database only, so none of these should have errors
	private function validateSkill(){
		$this->skill = $this->extractForm('skill');
		if(empty($this->skill))
			$this->setError('skill', 'SKILL_EMPTY');
	}
}
?>