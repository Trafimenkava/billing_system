<?php
	session_start();
	require_once("php/Database.php");
	require_once("php/Account.php");
	require_once("php/Service.php");
	require_once("php/TariffPlan.php");
	$oldSubscriptionFee = (double) $_POST["old_tp_sf"];
	$newTpTitle = $_POST["new_tp_title"];
	$serviceId = isset($_GET['id']) ? $_GET['id'] : ''; 
	$action = isset($_GET['action']) ? $_GET['action'] : ''; 
	$conn = DataBase::getConnection();
	$t_plan = new TariffPlan();
	$t_plan = $t_plan->getTariffPlanByTitle($conn, $newTpTitle);
	$newSubscriptionFee = $t_plan->getTariffPlanSubscriptionFee();
	$difference = $oldSubscriptionFee - $newSubscriptionFee;
	if ($action == "change") {
	    $service = new Service($serviceId);
	    $service = $service->getServiceById($conn);
	    if($difference > 0) {
	        $account = new Account();
	        $account = $account->getAccountByServiceId($conn, $serviceId);
	        $accountBalance = $account->getAccountBalance();
	        if ($accountBalance > $difference) {
	            $account->withdrawMoneyFromAccount($conn, $difference);
	            $service->updateServiceTariffPlan($conn, $t_plan->getTariffPlanId());
	        } 
	    } else {
	        $service->updateServiceTariffPlan($conn, $t_plan->getTariffPlanId());
	    }	    header("location:service_info.php?id=$serviceId");
	} else {
    	if($difference > 0) {
    	    echo "Абонентская плата за тарифный план $newTpTitle составляет $newSubscriptionFee руб/мес. Вы выбрали тарифный план в сторону уменьшения абонентской платы, поэтому с Вашего лицевого счета будет снято $difference руб.";
    	} else {
    	    echo "Абонентская плата за тарифный план $newTpTitle составляет $newSubscriptionFee руб/мес. Вы выбрали тарифный план в сторону увеличения абонентской платы, поэтому при переходе на этот тарифный план денежные средства взиматься не будут.";
    	}
	}
?>