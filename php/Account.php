<?php
require_once("Database.php");
require_once("QueryConsts.php");
	
class Account {
    public $account_id;
	public $client_id;
	private $params;
	
	public function __construct($account_id = null, $client_id = null) {
	    $this->account_id = $account_id;
		$this->client_id = $client_id;
	}
	
	public function getAccountByServiceId($conn, $id) {
		$result = $conn->selectRow(QueryConsts::GET_ACCOUNT_BY_SERVICE_ID_QUERY, array($id));
		$this->params = $result;
		$this->account_id = $this->getAccountId();
		return $this;
	}
	
	public function addAccount($conn) {	
		$result = $conn->query(QueryConsts::ADD_ACCOUNT_QUERY, array($this->client_id));
		return $result;
	}
	
	public function withdrawMoneyFromAccount($conn, $money) {	
		$result = $conn->query(QueryConsts::UPDATE_ACCOUNT_BALANCE, array($money, $this->account_id));
		return $result;
	}
	
	public function getAccountId() {
		return $this->params['account_id'];
	}
	
	public function getAccountBalance() {
		return $this->params['balance'];
	}
}
?>