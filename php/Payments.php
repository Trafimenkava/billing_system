<?php
require_once("Database.php");
require_once("QueryConsts.php");
require_once("Payment.php");
	
class Payments {	
	private $payments;

	public function __construct() {
		$this->payments = array();
	}
	
	public function getPaymentsByAccountId($conn, $account_id) {
		$result = $conn->select(QueryConsts::GET_PAYMENTS_BY_ACCOUNT_ID_QUERY, array($account_id));
		return $this->getPaymentsObjects($conn, $result);
	}
	
	public function getPaymentsObjects($conn, $result) {
		foreach($result as $res) {
			$p = new Payment($res['payment_id']);
			array_push($this->payments, $p->getPaymentById($conn));
		}
		return $this->payments;
	}	
}
?>