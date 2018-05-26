<?php
require_once("Database.php");
require_once("QueryConsts.php");
require_once("TariffPlanGroup.php");
	
class TariffPlanGroups {	
	private $tariff_plan_groups;

	public function __construct() {
		$this->tariff_plan_groups = array();
	}
	
	public function getTariffPlanGroups($conn) {
		$result = $conn->select(QueryConsts::GET_TARIFF_PLAN_GROUPS_QUERY);
		return $this->getTariffPlanGroupsObjects($conn, $result);
	}
	
	public function getTariffPlanGroupsObjects($conn, $result) {
		foreach($result as $res) {
			$t_plan_group = new TariffPlanGroup($res['tariff_plan_group_id'], null, null);
			array_push($this->tariff_plan_groups, $t_plan_group->getTariffPlanGroupById($conn));
		}
		return $this->tariff_plan_groups;
	}	
}
?>