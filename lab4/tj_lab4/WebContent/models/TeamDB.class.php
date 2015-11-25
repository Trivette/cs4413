<?php
class TeamDB {
	
	public static function addTeam($team) {
		// ...
		$query = "INSERT INTO teams (uid1, uid2, uid3, gameid)
		                      VALUES(:uid1, :uid2, :uid3, :gameid)";
		$returnId = 0;
		try {
			if (is_null($team) || $team->getErrorCount() > 0)
				throw new PDOException("Invalid Team object can't be inserted");
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":uid1", $team->getUID1());
			$statement->bindValue(":uid2", $team->getUID2());
			$statement->bindValue(":uid3", $team->getUID3());
			$statement->bindValue(":gameid", $team->getGameId());
			$statement->closeCursor();
			$returnId = $db->lastInsertId("teamid");
		} catch ( PDOException $e ) { // Not permanent error handling
			echo "<p>Error adding team to Teams ".$e->getMessage()."</p>";
		}
		return $returnId;
	}

	public static function getAllTeams() {
	   $query = "SELECT * FROM users ORDER BY skill DESC";
	   $teams = array();
	   try {
	      $db = Database::getDB();
	      $statement = $db->prepare($query);
	      $statement->execute();
	      $teams = TeamDB::getTeamsArray ($statement->fetchAll(PDO::FETCH_ASSOC));
	      $statement->closeCursor();
		} catch (PDOException $e) { // Not permanent error handling
			echo "<p>Error getting all users " . $e->getMessage () . "</p>";
		}
		return $teams;
	}
	
	public static function getTeamRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["id", "uid1", "uid2", "uid3", "gameid"];
		$teamRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT * FROM teams";
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Teams");
				$query = $query. " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else
				$statement = $db->prepare($query);
			$statement->execute ();
			$teamRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting team rows by $type: " . $e->getMessage () . "</p>";
		}
		return $teamRowSets;
	}
	
	public static function getTeamsArray($rowSets) {
		// Returns an array of User objects extracted from $rowSets
		$teams = array();
		if (!empty($rowSets)) {
			foreach ($rowSets as $teamRow ) {
				$team = new Team($teamRow);
				$team->setTeamId($teamRow['id']);
				array_push ($teams, $team);
			}
		}
		return $teams;
	}
	
	public static function getTeamsBy($type=null, $value=null) {
		// Returns User objects whose $type field has value $value
		$teamRows = TeamDB::getTeamRowSetsBy($type, $value);
		return TeamDB::getTeamsArray($teamRows);
	}
	
	public static function getTeamValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$teamValues = array();
		foreach ($rowSets as $teamRow )  {
			$teamValue = $teamRow[$column];
			array_push ($teamValues, $teamValue);
		}
		return $teamValues;
	}
	
	public static function getTeamValuesBy($column, $type=null, $value=null) {
		// Returns the $column of Teams whose $type field has value $value
		$teamRows = TeamDB::getTeamRowSetsBy($type, $value);
		return TeamDB::getTeamValues($teamRows, $column);
	}
	
	
	//Shouldn't need to updateTeam
	public static function updateTeam($team) {
		// Update a team
	}
}
?>