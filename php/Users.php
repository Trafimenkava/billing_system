<?php
require_once("Database.php");
require_once("QueryConsts.php");
require_once("User.php");
	
class Users {	
	public $users;

	public function __construct() {
		$this->users = array();
	}

	public function getAmountOfUsers($conn) {
		$result = $conn->getAmountOfRows(QueryConsts::GET_ALL_CLIENTS_QUERY);
		return $result;
	}
}
?>