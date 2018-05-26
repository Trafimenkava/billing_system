<?php
require_once("Database.php");
require_once("QueryConsts.php");
require_once("Service.php");
	
class Services {	
	private $services;

	public function __construct() {
		$this->services = array();
	}
	
	public function getAmountOfServices($conn) {
		$result = $conn->getAmountOfRows(QueryConsts::GET_SERVICES_QUERY);
		return $result;
	}

	public function getServicesByClientId($conn, $client_id) {
		$result = $conn->select(QueryConsts::GET_SERVICES_BY_CLIENT_ID_QUERY, array($client_id));
		return $this->getServicesObjects($conn, $result);
	}
	
	public function getServicesObjects($conn, $result) {
		foreach($result as $res) {
			$s = new Service($res['service_id'], null, null, null, null);
			array_push($this->services, $s->getServiceById($conn));
		}
		return $this->services;
	}	
	
	public function getMonthlyServices($conn) {
		$result = $conn->select(QueryConsts::GET_MONTHLY_SERVICES_QUERY);
		return $result;
	}
}
?>