<?php
	session_start();
	require_once("php/Database.php");
	require_once("php/TariffPlan.php");
	require_once("php/TariffPlanGroup.php");
	require_once("php/TariffPlanGroups.php");
	require_once("php/User.php");

	$conn = DataBase::getConnection();
	
	$action = $_GET["action"];
	$tariff_plan_id = isset($_GET['id']) ? $_GET['id'] : '';  
		
	$title = $_POST["title"];
	$description = $_POST["description"];
	$tariff_plan_group_title = $_POST["tariff_plan_group_title"];
	$internet_traffic = replaceEmptyFieldByNull($_POST["internet_traffic"]);
	$phone_traffic_within_network = replaceEmptyFieldByNull($_POST["phone_traffic_within_network"]);
	$phone_traffic_all_networks = replaceEmptyFieldByNull($_POST["phone_traffic_all_networks"]);
	$international_calls_traffic = replaceEmptyFieldByNull($_POST["international_calls_traffic"]);
	$sms_within_network = replaceEmptyFieldByNull($_POST["sms_within_network"]);
	$sms_all_networks = replaceEmptyFieldByNull($_POST["sms_all_networks"]);
	$mms_within_network = replaceEmptyFieldByNull($_POST["mms_within_network"]);
	$mms_all_networks = replaceEmptyFieldByNull($_POST["mms_all_networks"]);
	$favorite_numbers = replaceEmptyFieldByNull($_POST["favorite_numbers"]);
	$state = $_POST["state"];
	$subscription_fee = $_POST["subscription_fee"];
	
	$tariff_plan_gr = new TariffPlanGroup(null, $tariff_plan_group_title, null);
	$tariff_plans_group_id = $tariff_plan_gr->getTariffPlanGroupIdByTitle($conn);
	
	$params = array($title,
					$description, 
					$tariff_plans_group_id,
					$internet_traffic,
					$phone_traffic_within_network,
					$phone_traffic_all_networks,
					$international_calls_traffic,
					$sms_within_network,
					$sms_all_networks,
					$mms_within_network,
					$mms_all_networks,
					$favorite_numbers,
					$state,
					$subscription_fee);
					

	$tariff_plan = new TariffPlan($tariff_plan_id, $params);
					
	if($action == "add"){
        if(!empty($_POST)){
			$result = $tariff_plan->addTariffPlan($conn); 
			header("location: tariff_plan_page.php?id=$result");	
        }	
    } 
	
	if($action == "edit"){
        if(!empty($_POST)){
			$result = $tariff_plan->editTariffPlan($conn); 
			header("location: tariff_plan_page.php?id=$tariff_plan_id");	
        }		
    }

	function replaceEmptyFieldByNull($field) {
		return $field == '' ? 'NULL' : $field;
	}
?>
	
	
	
	
		
	