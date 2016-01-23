<?php
class GameDB {
	
	public static function addGame($game) {
		// Inserts the User object $user into the Users table and returns userId
		$query = "INSERT INTO games (teamid1, teamid2, pending, teamskill1, teamskill2, winreports, losereports, server, start, end, type)
		                      VALUES(:teamid1, :teamid2, :pending, :teamskill1, :teamskill2, :winreports, :losereports, :server, :start, :end, :type)";
		$returnId = 0;
		try {
			if (is_null($game) || $game->getErrorCount() > 0)
				throw new PDOException("Invalid Game object can't be inserted");
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":teamid1", $game->getTeamID1());
			$statement->bindValue(":teamid2", $game->getTeamID2());
			$statement->bindValue(":pending", $game->getPending());
			$statement->bindValue(":teamskill1", $game->getTeamSkill1());
			$statement->bindValue(":teamskill2", $game->getTeamSkill2());
			$statement->bindValue(":winreports", $game->getWinReports());
			$statement->bindValue(":losereports", $game->getLoseReports());
			$statement->bindValue(":server", $game->getServer());
			$statement->bindValue(":start", $game->getStart());
			$statement->bindValue(":end", $game->getEnd());
			$statement->bindValue(":type", $game->getType());
			$statement->execute ();
			$statement->closeCursor();
			$returnId = $db->lastInsertId("id");
		} catch ( Exception $e ) { // Not permanent error handling
			echo "<p>Error adding game to Games ".$e->getMessage()."</p>";
		}
		return $returnId;
	}

	public static function getAllGames() {
	   $query = "SELECT * FROM games";
	   $games = array();
	   try {
	      $db = Database::getDB();
	      $statement = $db->prepare($query);
	      $statement->execute();
	      $games = GameDB::getGamesArray ($statement->fetchAll(PDO::FETCH_ASSOC));
	      $statement->closeCursor();
		} catch (PDOException $e) { // Not permanent error handling
			echo "<p>Error getting all games " . $e->getMessage () . "</p>";
		}
		return $games;
	}
	
	public static function getAllGamesDesc() {
		$query = "SELECT * FROM games ORDER BY id DESC";
		$games = array();
		try {
			$db = Database::getDB();
			$statement = $db->prepare($query);
			$statement->execute();
			$games = GameDB::getGamesArray ($statement->fetchAll(PDO::FETCH_ASSOC));
			$statement->closeCursor();
		} catch (PDOException $e) { // Not permanent error handling
			echo "<p>Error getting all games " . $e->getMessage () . "</p>";
		}
		return $games;
	}
	
	public static function getGameRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["id", "pending", "server", "teamid1", "teamid2"];
		$gameRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT * FROM games";
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Games");
				$query = $query. " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else
				$statement = $db->prepare($query);
			$statement->execute ();
			$gameRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting game rows by $type: " . $e->getMessage () . "</p>";
		}
		return $gameRowSets;
	}
	
	public static function getGamesArray($rowSets) {
		// Returns an array of User objects extracted from $rowSets
		$games = array();
		if (!empty($rowSets)) {
			foreach ($rowSets as $gameRow ) {
				$game = new Game($gameRow);
				//$user->setUserId($userRow['userId']);
				array_push ($games, $game );
			}
		}
		return $games;
	}
	
	public static function getGamesBy($type=null, $value=null) {
		// Returns User objects whose $type field has value $value
		$gameRows = GameDB::getGameRowSetsBy($type, $value);
		return GameDB::getGamesArray($gameRows);
	}
	
	public static function getGameValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$gameValues = array();
		foreach ($rowSets as $gameRow )  {
			$gameValue = $gameRow[$column];
			array_push ($gameValues, $gameValue);
		}
		return $gameValues;
	}
	
	public static function getGameValuesBy($column, $type=null, $value=null) {
		// Returns the $column of Users whose $type field has value $value
		$gameRows = GameDB::getGameRowSetsBy($type, $value);
		return GameDB::getGameValues($gameRows, $column);
	}
	
	public static function updateGame($game) {
		// Update a user
		try {
			$db = Database::getDB ();
			if (is_null($game) || $game->getErrorCount() > 0)
				return $game;
			$checkGame = GameDB::getGamesBy('id', $game->getID());
			if (empty($checkGame))
				$game->setError('id', 'GAME_DOES_NOT_EXIST');
			if ($game->getErrorCount() > 0)
				return $game;
	
			$query = "UPDATE games SET 
					pending = :pending, 
					losereports = :losereport, 
					winreports = :winreport, 
					end = :end, 
					teamid1 = :teamid1, 
					teamid2 = :teamid2 
	    			WHERE id = :id";
	
			$statement = $db->prepare ($query);
			$statement->bindValue(":id", $game->getID());
			$statement->bindValue(":pending", $game->getPending());
			$statement->bindValue(":losereport", $game->getLoseReports());
			$statement->bindValue(":winreport", $game->getWinReports());
			$statement->bindValue(":end", $game->getEnd());
			$statement->bindValue(":teamid1", $game->getTeamId1());
			$statement->bindValue(":teamid2", $game->getTeamId2());
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			$game->setError('id', 'GAME_COULD_NOT_BE_UPDATED');
		}
		return $game;
	}
}
?>