<?php
	require_once("php/Database.php");
	require_once("php/QueryConsts.php");
	require_once("php/Service.php");
	require_once("php/Account.php");
	require_once("php/Notification.php");
	const TRIGGER_TYPE_MONEY_LACK = "Недостаток средств";
	const TRIGGER_TYPE_BLOCKING = "Блокировка услуги";
	const SERVICE_STATUS_ACTIVE = 'Активна';
	const SERVICE_STATUS_BLOCKED = 'Заблокирована';
	$conn = DataBase::getConnection();	
	$services = $conn->select(QueryConsts::GET_SERVICES_FOR_ACTIVATION_QUERY);
	foreach($services as $service) {
	    $serviceObject = new Service($service['service_id']);
	    $balance = (double) $service['balance'];
	    $subscriptionFee = (double) $service['subscription_fee'];
	    $triggerType = null;

	    if ($balance >= $subscriptionFee) {
	        $serviceObject->setServiceStatus($conn, SERVICE_STATUS_ACTIVE);
	        $serviceObject->setIsOutstandingFlag($conn, 0);
	        $account = new Account($service['account_id'], null);
	        $account->withdrawMoneyFromAccount($conn, $subscriptionFee);
	    } else if ($balance >= -$subscriptionFee) {
	        $triggerType = TRIGGER_TYPE_MONEY_LACK;
	        $serviceObject->setIsOutstandingFlag($conn, 1);
	        $serviceObject->setServiceStatus($conn, SERVICE_STATUS_ACTIVE);
	    } else {
	        $triggerType = TRIGGER_TYPE_BLOCKING;
	        $serviceObject->setIsOutstandingFlag($conn, 1);
	        $serviceObject->setServiceStatus($conn, SERVICE_STATUS_BLOCKED);
	    }
	    
	    if ($triggerType != null) {
	        $notification = new Notification();
    	    $notificationParams = array(
            	'$_SURNAME', $service['surname'],
            	'$_NAME', $service['name'],
            	'$_LASTNAME', $service['lastname'],
            	'$_TARIFF_PLAN_TITLE', $service['title'],
            	'$_TELEPHONE_NUMBER', $service['telephone_number']
            );
            $notification->getNotificationByTriggerType($conn, $triggerType)->sendNotification($conn, $service['email'], $notificationParams);
	    }
	}
?>