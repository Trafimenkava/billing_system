<?php
require_once("Database.php");
require_once("QueryConsts.php");
require_once("Notification.php");
	
class Notifications {	
	private $notifications;

	public function __construct() {
		$this->notifications = array();
	}
	
	public function getNotifications($conn) {
		$result = $conn->select(QueryConsts::GET_NOTIFICATIONS_QUERY);
		return $this->getNotificationsObjects($conn, $result);
	}
	
	public function getNotificationsObjects($conn, $result) {
		foreach($result as $res) {
			$n = new Notification($res['notification_id']);
			array_push($this->notifications, $n->getNotificationById($conn));
		}
		return $this->notifications;
	}	
}
?>