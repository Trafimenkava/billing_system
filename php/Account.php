<?php
require_once("Database.php");
require_once("QueryConsts.php");
	
class Account {
	public $client_id;
	private $params;
	
	public function __construct($client_id = null) {
		$this->client_id = $client_id;
	}
	
	public function getAccountByServiceId($conn, $id) {
		$result = $conn->selectRow(QueryConsts::GET_ACCOUNT_BY_SERVICE_ID_QUERY, array($id));
		$this->params = $result;
		return $this;
	}
	
	public function addAccount($conn) {	
		$result = $conn->query(QueryConsts::ADD_ACCOUNT_QUERY, array($this->client_id));
		return $result;
	}
	
	public function getAccountId() {
		return $this->params['account_id'];
	}
}
?>