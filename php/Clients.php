<?php
require_once("Database.php");
require_once("QueryConsts.php");
require_once("Users.php");
require_once("Client.php");
	
class Clients extends Users {
	public function __construct() {
		parent::__construct();
	}
	
	public function getClients($conn, $offset) {
		$result = $conn->select(QueryConsts::GET_CLIENTS_QUERY, $offset); 
		return $this->getClientsObjects($conn, $result);
	}
	
	public function getClientsObjects($conn, $result) {
		foreach($result as $res) {
			$user = new Client($res['user_id'], null, null);
			array_push($this->users, $user->getClientById($conn));
		}
		return $this->users;
	}
}
?>