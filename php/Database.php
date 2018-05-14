<?php
class Database {
	private static $conn = null;
	private $mysqli;

	const MYSQL_SERVER = "localhost";
	const MYSQL_USER = "id5508922_billing_system_admin";
	const MYSQL_PASSWORD = "Mc2435330";
	const MYSQL_DB = "id5508922_billing_system";
	const QUERY_PARAMS_FILLER = "?"; 
	
	private function __construct() {
		$this->mysqli = new mysqli(self::MYSQL_SERVER, self::MYSQL_USER, self::MYSQL_PASSWORD, self::MYSQL_DB);
		$this->mysqli->query("SET NAMES 'utf8'");
	}
	
	public function __destruct() {
		if ($this->mysqli) $this->mysqli->close();
	}
	
	public static function getConnection() {
		if (self::$conn == null) self::$conn = new DataBase();
		return self::$conn;
	}

	// should be private
	// made public for testing purposes
	public function getQuery($query, $params) {
		if ($params) {
			for ($i = 0; $i < count($params); $i++) {
				$pos = strpos($query, self::QUERY_PARAMS_FILLER);
				$arg = $params[$i];
				$query = substr_replace($query, $arg, $pos, strlen(self::QUERY_PARAMS_FILLER));
			}
		}
		return $query;
	}

	public function select($query, $params = false) {
		$result_set = $this->mysqli->query($this->getQuery($query, $params));
		if (!$result_set) return false;
		return $this->resultSetToArray($result_set);
	}
	
	public function selectRow($query, $params = false) {
		$result_set = $this->mysqli->query($this->getQuery($query, $params));
		if ($result_set->num_rows != 1) return false;
		else return $result_set->fetch_assoc();
	}
	
	public function selectCell($query, $params = false) {
		$result_set = $this->mysqli->query($this->getQuery($query, $params));
		if ((!$result_set) || ($result_set->num_rows != 1)) return false;
		else {
			$arr = array_values($result_set->fetch_assoc());
			return $arr[0];
		}
	}
	
	public function getAmountOfRows($query, $params = false) {
		$result_set = $this->mysqli->query($this->getQuery($query, $params));
		return $result_set->num_rows;
	}

	public function query($query, $params = false) {
		$success = $this->mysqli->query($this->getQuery($query, $params));
		if ($success) {
			return $this->mysqli->insert_id;
		}
		else return false;
    }

	private function resultSetToArray($result_set) {
		$array = array();
		while (($row = $result_set->fetch_assoc()) != false) {
			$array[] = $row;
		}
		return $array;
	}
}
?>