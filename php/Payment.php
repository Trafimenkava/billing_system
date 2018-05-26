<?php
require_once("Database.php");
require_once("QueryConsts.php");
	
class Payment {
	public $id;
	private $params;
	
	public function __construct($id) {
		$this->id = $id;
	}
	
	public function getPaymentById($conn) {
		$result = $conn->selectRow(QueryConsts::GET_PAYMENT_BY_PAYMENT_ID_QUERY, array($this->id));
		$this->params = $result;
		return $this;
	}
	
	public function getPaymentId() {
		return $this->params['payment_id'];
	}

	public function getPaymentMoney() {
		return $this->params['amount_of_money'];
	}
	
	public function getPaymentDate() {
		return $this->params['date'];
	}
}
?>