<?php
class HockUserDB {
	
	public static function addUser($user) {
		// Inserts the User object $user into the Users table and returns userId
		$query = "INSERT INTO users (name)
		                      VALUES(:name)";
		$returnId = 0;
		try {
			if (is_null($user) || $user->getErrorCount() > 0)
				throw new PDOException("Invalid User object can't be inserted");
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":name", $user->getUserName());
			$statement->closeCursor();
			$returnId = $db->lastInsertId("userId");
		} catch ( PDOException $e ) { // Not permanent error handling
			echo "<p>Error adding user to Users ".$e->getMessage()."</p>";
		}
		return $returnId;
	}

	public static function getAllUsers() {
	   $query = "SELECT * FROM users";
	   $users = array();
	   try {
	      $db = Database::getDB();
	      $statement = $db->prepare($query);
	      $statement->execute();
	      $users = HockUsersDB::getUsersArray ($statement->fetchAll(PDO::FETCH_ASSOC));
	      $statement->closeCursor();
		} catch (PDOException $e) { // Not permanent error handling
			echo "<p>Error getting all users " . $e->getMessage () . "</p>";
		}
		return $users;
	}
	
	public static function getUserRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["id", "name", "alias"];
		$userRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT * FROM users";
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Users");
				$query = $query. " WHERE ($type = :$type)";
				$statement = $db->prepare($query);
				$statement->bindParam(":$type", $value);
			} else
				$statement = $db->prepare($query);
			$statement->execute ();
			$userRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting user rows by $type: " . $e->getMessage () . "</p>";
		}
		return $userRowSets;
	}
	
	public static function getUsersArray($rowSets) {
		// Returns an array of User objects extracted from $rowSets
		$users = array();
		if (!empty($rowSets)) {
			foreach ($rowSets as $userRow ) {
				$user = new HockUser($userRow);
				//$user->setUserId($userRow['userId']);
				array_push ($users, $user );
			}
		}
		return $users;
	}
	
	public static function getUsersBy($type=null, $value=null) {
		// Returns User objects whose $type field has value $value
		$userRows = HockUsersDB::getUserRowSetsBy($type, $value);
		return HockUsersDB::getUsersArray($userRows);
	}
	
	public static function getUserValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$userValues = array();
		foreach ($rowSets as $userRow )  {
			$userValue = $userRow[$column];
			array_push ($userValues, $userValue);
		}
		return $userValues;
	}
	
	public static function getUserValuesBy($column, $type=null, $value=null) {
		// Returns the $column of Users whose $type field has value $value
		$userRows = HockUsersDB::getUserRowSetsBy($type, $value);
		return HockUsersDB::getUserValues($userRows, $column);
	}
	
	public static function updateUser($user) {
		// Update a user
		try {
			$db = Database::getDB ();
			if (is_null($user) || $user->getErrorCount() > 0)
				return $user;
			$checkUser = HockUsersDB::getUsersBy('id', $user->getUserId());
			if (empty($checkUser))
				$user->setError('id', 'USER_DOES_NOT_EXIST');
			if ($user->getErrorCount() > 0)
				return $user;
	
			$query = "UPDATE users SET name = :name WHERE id = :id";
	
			$statement = $db->prepare ($query);
			$statement->bindValue(":name", $user->getUserName());
			$statement->bindValue(":id", $user->getUserId());
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			$user->setError('id', 'USER_COULD_NOT_BE_UPDATED');
		}
		return $user;
	}
}
?>