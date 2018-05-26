<?php
require_once("Database.php");
require_once("TariffPlan.php");
require_once("QueryConsts.php");
	
class TariffPlans {
	private $tariff_plans;
	
	public function __construct() {
		$this->tariff_plans = array();
	}
	
	public function getAmountOfTariffPlans($conn) {
		$result = $conn->getAmountOfRows(QueryConsts::GET_TARIFF_PLANS_QUERY);
		return $result;
	}

	public function getAllTariffPlans($conn) {
		$tariff_plans = $conn->select(QueryConsts::GET_TARIFF_PLANS_QUERY);
		return $this->getTariffPlansObjects($conn, $tariff_plans);
	}
	
	public function getActiveTariffPlans($conn) {
		$tariff_plans = $conn->select(QueryConsts::GET_ACTIVE_TARIFF_PLANS_QUERY);
		return $this->getTariffPlansObjects($conn, $tariff_plans);
	}
	
	public function getPopularTariffPlans($conn) {
		$tariff_plans = $conn->select(QueryConsts::GET_POPULAR_TARIFF_PLANS_QUERY );
		return $tariff_plans;
	}
	
	public function getDistributionOfTariffPlans($conn) {
		$tariff_plans = $conn->select(QueryConsts::GET_DISTRIBUTION_OF_TARIFF_PLANS_QUERY);
		return $tariff_plans;
	}
	
	public function getTariffPlansByTariffPlanGroupId($conn, $id) {
		$tariff_plans = $conn->select(QueryConsts::GET_TARIFF_PLAN_BY_TARIFF_PLAN_GROUP_ID_QUERY, array($id));
		return $this->getTariffPlansObjects($conn, $tariff_plans);
	}
	
	public function getTariffPlansObjects($conn, $tariff_plans) {
		foreach($tariff_plans as $tariff_plan) {
			$t_plan = new TariffPlan($tariff_plan['tariff_plan_id'], array());
			array_push($this->tariff_plans, $t_plan->getTariffPlanById($conn));
		}
		return $this->tariff_plans;
	}	
}
?>