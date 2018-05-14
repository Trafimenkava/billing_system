<?php
session_start();
require_once("php/Database.php");
require_once("php/QueryConsts.php");
require_once("php/User.php");
require_once("php/Notification.php");

const PASSWORD_PATTERN = "/^[\da-zA-Z]{8,16}$/";
const TRIGGER_TYPE_REGISTRATION = "Регистрация";

if(isset($_POST["register"])){
	$conn = DataBase::getConnection();
	$surname = trim($_POST['surname']);
	$name = trim($_POST['name']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeat_password = trim($_POST['repeat_password']);
	$is_admin = isset($_POST['is_admin']) ? trim($_POST['is_admin']) : ''; 
	$is_admin = $is_admin == "on" ? 1 : 0;
	$message = '';
	
	$notificationParams = array(
		'$_SURNAME', $surname,
		'$_NAME', $name,
		'$_LASTNAME', $lastname,
		'$_EMAIL', $email,
		'$_PASSWORD', $password
	);

	if ($password != $repeat_password) {
		$message = "Пароли не совпадают!";
	} else if (!preg_match(PASSWORD_PATTERN, $password)) {
		$message = "Пароль должен состоять из 8-16 символов и содержать заглавные, строчные буквы, а также цифры!";
	} else {		
		$user = new User(null, null, $email);
		$result = $user->checkUserWithGivenEmailNotExist($conn);	
			
		if($result) {
		    $password = password_hash($password, PASSWORD_DEFAULT);
		    // $password = crypt($password);
			$result = $user->addUser($conn,	array($name, $surname, $lastname, $email, $password, date("Y-m-d H:i:s"), $is_admin));
			
			if($result){ 
				$user->addClientId($conn, $result);
				
				$notification = new Notification();
				$notification = $notification->getNotificationByTriggerType($conn, TRIGGER_TYPE_REGISTRATION)->sendNotification($conn, $email, $notificationParams);
	
				$success = "Пользователь $surname $name $lastname был успешно создан!";
			} else {
				$message = "Ошибка при добавлении данных!";
			}
		} else { 
			$message = "Пользователь с email " . $email . " уже существует!";
		}
	}
	header("location: add_user.php?message=$message&success=$success");
}
?>
	
	
	
	
		
	