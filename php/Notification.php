<?php
require_once("Database.php");
require_once("QueryConsts.php");
	
class Notification {	
	public $id;
	public $to;
	public $from;
	public $subject;
	public $content;
	public $trigger;
	
	public $params;

	public function __construct($id = null, $to = null, $from = null, $subject = null, $content = null, $trigger = null) {
		$this->id = $id;
		$this->to = $to;
		$this->from = $from;
		$this->subject = $subject;
		$this->content = $content;
		$this->trigger = $trigger;
	}
	
	public function getNotificationById($conn) {
		$result = $conn->selectRow(QueryConsts::GET_NOTIFICATION_BY_NOTIFICATION_ID_QUERY, array($this->id));
		$this->params = $result;
		return $this;
	}
	
	public function getNotificationByTriggerType($conn, $triggerType) {
		$result = $conn->selectRow(QueryConsts::GET_NOTIFICATION_BY_TRIGGER_TYPE_QUERY, array($triggerType));
		$this->params = $result;
		return $this;
	}
	
	public function addNotification($conn) {
		$result = $conn->query(QueryConsts::ADD_NOTIFICATION_QUERY, array($this->to, $this->from, $this->subject, $this->content, $this->trigger));	
		return $result;
	}
	
	public function editNotification($conn) {
		$result = $conn->query(QueryConsts::UPDATE_NOTIFICATION_QUERY, array($this->to, $this->from, $this->subject, $this->content, $this->trigger, $this->id));
		return $result;
	}

	public function deleteNotification($conn) {
		$result = $conn->query(QueryConsts::DELETE_NOTIFICATION_BY_NOTIFICATION_ID_QUERY, array($this->id));
		return $result;
	}
	
	public function sendNotification($conn, $to_send, $notificationParams) {
		$from_send = $this->getNotificationFrom();
		$headers = "From: $from_send\r\nReply-to:$from_send\r\nContent-type:text/html;charset=utf-8\r\n";
		
		$notificationSubject = $this->getNotificationSubject();
		$notificationContent = $this->getNotificationContent();
		
		while(list(,$key) = each($notificationParams)) {
			list(,$value) = each($notificationParams);
			$notificationSubject = str_replace($key, $value, $notificationSubject);
			$notificationContent = str_replace($key, $value, $notificationContent);
		}
		
		mail($to_send, $notificationSubject, $notificationContent, $headers); 
	}
	
	public function getNotificationId() {
		return $this->id;
	}
	
	public function getNotificationTo() {
		return $this->params['send_to'];
	}
	
	public function getNotificationFrom() {
		return $this->params['send_from'];
	}
	
	public function getNotificationSubject() {
		return $this->params['subject'];
	}
	
	public function getNotificationContent() {
		return $this->params['content'];
	}
	
	public function getNotificationTrigger() {
		return $this->params['trigger_type'];
	}
}
?>