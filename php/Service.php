<?php
require_once("Database.php");
require_once("QueryConsts.php");
	
class Service {
	public $id;
	public $client_id;
	public $tariff_plan_id;
	public $telephone_number;
	public $status;
	public $params;
	
	public function __construct($id, $client_id = null, $tariff_plan_id = null, $telephone_number = null, $status = null) {
		$this->id = $id;
		$this->client_id = $client_id;
		$this->tariff_plan_id = $tariff_plan_id;
		$this->telephone_number = $telephone_number;
		$this->status = $status;
	}
	
	public function getServiceById($conn) {
		$result = $conn->selectRow(QueryConsts::GET_SERVICE_BY_SERVICE_ID_QUERY, array($this->id));
		$this->params = $result;
		return $this;
	}
	
   	public function getServiceId() {
		return $this->id;
	}
    
	public function getTariffPlanId() {
		return $this->params['tariff_plan_id'];
	}
	
	public function addService($conn) {	
		$result = $conn->query(QueryConsts::ADD_SERVICE_QUERY, 
								array($this->client_id, $this->tariff_plan_id, $this->telephone_number, $this->status));
		return $result;
	}
	
	public function updateServiceTariffPlan($conn, $tp_id) {	
		$result = $conn->query(QueryConsts::UPDATE_SERVICE_TARIFF_PLAN_QUERY, array($tp_id, $this->id));
		return $result;
	}
	
	public function setServiceStatus($conn, $status) {
        $result = $conn->query(QueryConsts::UPDATE_SERVICE_STATUS, array($status, $this->id));
        return $result;
    }
	
	public function setIsOutstandingFlag($conn, $flag) {
        $result = $conn->query(QueryConsts::UPDATE_SERVICE_IS_OUTSTANDING_FLAG, array($flag, $this->id));
        return $result;
    }
	
	public function getServiceClientId() {
		return $this->params['client_id'];
	}
	
	public function getServiceStatus() {
		return $this->params['status'];
	}
	
	public function getServiceTelephoneNumber() {
		return $this->params['telephone_number'];
	}
	
	public function getServiceConnectionDate() {
		return $this->params['connection_date'];
	}
	
	public function getServiceDisconnectionDate() {
		return $this->params['disconnection_date'];
	}
}
?>