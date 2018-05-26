<?php
require_once("Database.php");
require_once("QueryConsts.php");
	
class TariffPlanGroup {
	private $id;
	private $title;
	private $description;
	
	public function __construct($id, $title, $description) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
	}
	
	public function getTariffPlanGroupById($conn) {
		$result = $conn->selectRow(QueryConsts::GET_TARIFF_PLAN_GROUP_BY_TARIFF_PLAN_GROUP_ID_QUERY, array($this->id));
		$this->setParams($result);
		return $this;
	}
	
	public function getTariffPlanGroupIdByTitle($conn) {
		$result = $conn->selectCell(QueryConsts::GET_TARIFF_PLAN_GROUP_BY_TITLE_QUERY, array($this->title));
		return $result;
	}
	
	public function addTariffPlanGroup($conn) {	
		$result = $conn->query(QueryConsts::ADD_TARIFF_PLAN_GROUP_QUERY, array($this->title, $this->description));
		return $result;
	}
	
	public function editTariffPlanGroup($conn) {
		$result = $conn->query(QueryConsts::UPDATE_TARIFF_PLAN_GROUP_QUERY, array($this->title, $this->description, $this->id));
		return $result;
	}
	
	public function deleteTariffPlanGroup($conn) {	
		$result = $conn->query(QueryConsts::DELETE_TARIFF_PLAN_GROUP_BY_TARIFF_PLAN_GROUP_ID_QUERY, array($this->id));
		return $result;
	}
	
	public function getTariffPlanGroupId() {
		return $this->id;
	}
	
	public function getTariffPlanGroupTitle() {
		return $this->title;
	}
	
	public function getTariffPlanGroupDescription() {
		return $this->description;
	}
	
	private function setParams($result) {
		$this->id = $result['tariff_plan_group_id'];
		$this->title = $result['title'];
		$this->description = $result['description'];
	}
}
?>