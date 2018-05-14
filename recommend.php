<?php
	session_start();
	require_once("php/Database.php");
	require_once("php/QueryConsts.php");
	
	$purpose =  trim($_POST["purpose"]);
	$min_abonplata = (double) $_POST["minabonplata"];
	$max_abonplata = (double) $_POST["maxabonplata"];
	$favorite_numbers = $_POST["favoritenumbers"];
	$international_calls = isset($_POST['internationalcalls']) ? $_POST['internationalcalls'] : '';
	$traffic = $_POST["traffic"];
	
	$conn = DataBase::getConnection();	
	$resultQuery = QueryConsts::GET_TARIFF_PLANS_FOR_RECOMMENDATION_QUERY;
	
	if ($purpose == "для звонков") {
		$param1 = "(phone_traffic_within_network_min or phone_traffic_all_networks_min)";
	} else if ($purpose == "для доступа в интернет") {
		$param1 = "internet_traffic_mb";
	} else {
		$param1 = "(phone_traffic_within_network_min or phone_traffic_all_networks_min) and internet_traffic_mb";
	}
	
	$params = array($param1, $min_abonplata, $max_abonplata);
	
	if (!empty($favorite_numbers)) {
		$resultQuery .= QueryConsts::ADDITIONAL_CHECK_FOR_AMOUNT_OF_FAVORITE_NUMBERS;
		array_push($params, (int) $favorite_numbers);
	}
	
	if ($international_calls == "on") {
		$resultQuery .= QueryConsts::ADDITIONAL_CHECK_FOR_PRESENCE_OF_INTERNATIONAL_CALLS;
	}
	
	if (!empty($traffic)) {
		$isTrafficCanBeInfinity = false;
		if ($traffic == "1-") {
			array_push($params, 0, 1024);
		} else if ($traffic == "1-5") {
			array_push($params, 1024, 5120);
		} else if ($traffic == "5-10") {
			array_push($params, 5120, 10240);
		} else if ($traffic == "10+") {
			$isTrafficCanBeInfinity = true;
			array_push($params, 10240);
		}
		$resultQuery .= $isTrafficCanBeInfinity ? 
						QueryConsts::ADDITIONAL_CHECK2_FOR_INTERNET_TRAFFIC : 
						QueryConsts::ADDITIONAL_CHECK1_FOR_INTERNET_TRAFFIC;
	}
	
	$tariff_plans = $conn->select($resultQuery, $params);
	
	$result = '';
	if (!$tariff_plans) {
		$result = "Не удалось найти данных.";
	}
	
	foreach($tariff_plans as $tariff_plan) {
		$result .= "<h2><strong>" . $tariff_plan['title'] . "</strong></h2>";
		$result .= "<hp>" . replaceNullByZero($tariff_plan['internet_traffic_mb']) . " МБ Интернета, ";
		$result .= "<hp>" . replaceNullByZero($tariff_plan['phone_traffic_within_network_min']) . " мин внутри сети и ";
		$result .= "<hp>" . replaceNullByZero($tariff_plan['phone_traffic_all_networks_min']) . " мин во все сети, ";
		$result .= "абонентская плата " . $tariff_plan['subscription_fee'] . " руб/мес</p><hr>";
	}
	
	echo $result;
	
	function replaceNullByZero($str) {
		return $str == null ? 0 : $str;
	}
?>