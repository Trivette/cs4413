<?php
class BetDB {
	
	public static function addBet($bet) {
		// Inserts the Bet object $bet into the bets table and returns betid
		$query = "INSERT INTO bets (who, game, team, wager)
		                      VALUES(:who, :game, :team, :wager)";
		$returnId = 0;
		try {
			if (is_null($bet) || $bet->getErrorCount() > 0)
				throw new PDOException("Invalid Bet object can't be inserted");
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":who", $bet->getUser());
			$statement->bindValue(":game", $bet->getGameID());
			$statement->bindValue(":team", $bet->getTeam());
			$statement->bindValue(":wager", $bet->getBetAmount());
			$statement->execute ();
			$statement->closeCursor();
			$returnId = $db->lastInsertId("id");
		} catch ( Exception $e ) { // Not permanent error handling
			echo "<p>Error adding bet to bets ".$e->getMessage()."</p>";
		}
		return $returnId;
	}

	public static function getAllBets() {
	   $query = "SELECT * FROM bets";
	   $bets = array();
	   try {
	      $db = Database::getDB();
	      $statement = $db->prepare($query);
	      $statement->execute();
	      $bets = BetDB::getBetsArray ($statement->fetchAll(PDO::FETCH_ASSOC));
	      $statement->closeCursor();
		} catch (PDOException $e) { // Not permanent error handling
			echo "<p>Error getting all bets " . $e->getMessage () . "</p>";
		}
		return $bets;
	}
	
	public static function getBetRowSetsBy($type = null, $value = null) {
		// Returns the rows of bets whose $type field has value $value
		$allowedTypes = ["id", "who", "game"];
		$betRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT * FROM bets";
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for bets");
				$query = $query. " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else
				$statement = $db->prepare($query);
			$statement->execute ();
			$betRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting bets rows by $type: " . $e->getMessage () . "</p>";
		}
		return $betRowSets;
	}
	
	public static function getBetsArray($rowSets) {
		// Returns an array of bet objects extracted from $rowSets
		$bets = array();
		if (!empty($rowSets)) {
			foreach ($rowSets as $betRow ) {
				$bet = new Bet($betRow);
				$bet->setBetID($betRow['id']);
				array_push ($bets, $bet);
			}
		}
		return $bets;
	}
	
	public static function getBetsBy($type=null, $value=null) {
		// Returns bet objects whose $type field has value $value
		$betRows = BetDB::getBetRowSetsBy($type, $value);
		return BetDB::getBetsArray($betRows);
	}
	
	public static function getBetValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$betValues = array();
		foreach ($rowSets as $betRow )  {
			$betValue = $betRow[$column];
			array_push ($betValues, $betValue);
		}
		return $betValues;
	}
	
	public static function getBetValuesBy($column, $type=null, $value=null) {
		// Returns the $column of bets whose $type field has value $value
		$betRows = BetDB::getBetRowSetsBy($type, $value);
		return BetDB::getBetValues($betRows, $column);
	}
}
?>