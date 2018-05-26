<?php
require_once("Database.php");
require_once("QueryConsts.php");
require_once("User.php");
	
class Client extends User {	
	public function __construct($id, $fio = null, $email = null) {
		parent::__construct($id, $fio, $email);
	}
	
	public function getClientById($conn) {
		$result = $conn->selectRow(QueryConsts::GET_CLIENT_BY_ID_QUERY, array($this->id));
		$this->params = $result;
		return $this;
	}
	
	public function getClientByFio($conn) {
		$result = $conn->selectRow(QueryConsts::GET_CLIENT_BY_FIO_QUERY, array($this->fio));
		$this->params = $result;
		return $this;
	}
	
	public function addClient($conn, $params) {	
		$result = $conn->query(QueryConsts::ADD_USER_QUERY, $params);
		return $result;
	}
	
	public function editClient($conn, $params) {	
		$result = $conn->query(QueryConsts::UPDATE_CLIENT_QUERY, $params);
		return $result;
	}
		
	public function deleteClient($conn, $id) {
		$result = $conn->query(QueryConsts::DELETE_CLIENT_BY_CLIENT_ID_QUERY, array($this->id));
		return $result;
	}
    
    public function getClientStatus() {
		return $this->params['status'];
	}
	
	public function getClientPassportNumber() {
		return $this->params['passport_number'];
	}
	
	public function getClientBirthdayDate() {
		return $this->params['birthday_date'];
	}
	
	public function getClientAddress() {
		return $this->params['address'];
	}
	
	public function getClientCardNumber() {
		return $this->params['card_number'];
	}
	
}
?>