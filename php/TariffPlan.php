<?php
require_once("Database.php");
require_once("QueryConsts.php");
	
class TariffPlan {
	private $id;
	private $values;
	
	private $params;
	
	public function __construct($id = null, $values = array()) {
		$this->values = $values;
		$this->id = $id;
	}
	
	public function getTariffPlanById($conn) {
		$result = $conn->selectRow(QueryConsts::GET_TARIFF_PLAN_BY_TARIFF_PLAN_ID_QUERY, array($this->id));
		$this->params = $result;
		return $this;
	}
	
	public function getTariffPlanByTitle($conn, $title) {
		$result = $conn->selectRow(QueryConsts::GET_TARIFF_PLAN_BY_TARIFF_PLAN_TITLE_QUERY, array($title));
		$this->id = $result['tariff_plan_id'];
		$this->params = $result;
		return $this;
	}
	
	public function addTariffPlan($conn) {	
		$result = $conn->query(QueryConsts::ADD_TARIFF_PLAN_QUERY, $this->values);
		return $result;
	}
	
	public function editTariffPlan($conn) {
		array_push($this->values, $this->id);
		$result = $conn->query(QueryConsts::UPDATE_TARIFF_PLAN_QUERY, $this->values);
		return $result;
	}
	
	public function deleteTariffPlan($conn) {
		$result = $conn->query(QueryConsts::DELETE_TARIFF_PLAN_BY_TARIFF_PLAN_ID_QUERY, array($this->id));
		return $result;
	}
	
    public function getTariffPlanId() {
		return $this->id;
	}
    
	public function getTariffPlanTitle() {
		return $this->params['tariff_plan_title'];
	}
	
	public function getTariffPlanDescription() {
		return $this->params['tariff_plan_description'];
	}
    
    public function getTariffPlanGroupTitle() {
		return $this->params['tariff_plan_group_title'];
	}
    
    public function getTariffPlanInternetTrafficMb() {
		return $this->params['internet_traffic_mb'];
	}
    
    public function getTariffPlanPhoneTrafficWithinNetworkMin() {
		return $this->params['phone_traffic_within_network_min'];
	}
    
    public function getTariffPlanPhoneTrafficAllNetworksMin() {
		return $this->params['phone_traffic_all_networks_min'];
	}
    
    public function getTariffPlanInternationalCallsTrafficMin() {
		return $this->params['international_calls_traffic_min'];
	}
    
    public function getTariffPlanSmsWithinNetwork() {
		return $this->params['sms_within_network'];
	}
    
    public function getTariffPlanSmsAllNetworks() {
		return $this->params['sms_all_networks'];
	}
    
    public function getTariffPlanMmsWithinNetwork() {
		return $this->params['mms_within_network'];
	}
	
	 public function getTariffPlanMmsAllNetworks() {
		return $this->params['mms_all_networks'];
	}
    
    public function getTariffPlanFavoriteNumbersAmount() {
		return $this->params['favorite_numbers_amount'];
	}
	
	public function getTariffPlanState() {
		return $this->params['state'];
	}
    
    public function getTariffPlanSubscriptionFee() {
		return $this->params['subscription_fee'];
	}
}
?>