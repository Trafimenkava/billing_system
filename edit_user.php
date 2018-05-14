<?php
session_start();
require_once("php/Database.php");
require_once("php/QueryConsts.php");
require_once("php/User.php");
require_once("php/Client.php");

$id = $_GET['id'];
$action = $_GET["action"];

$conn = DataBase::getConnection();

if ($action == "edit_general_info") {
	$surname = trim($_POST['surname']);
	$name = trim($_POST['name']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$is_admin = isset($_POST['is_admin']) ? trim($_POST['is_admin']) : '';
	$photo = $_FILES['file'];
	$photoName = $photo['name'];

	$is_admin = $is_admin == "on" ? 1 : 0;
	
	$user = new User($id, null, null);
	
	if (!empty($photoName)) {
		$photoName = $photo['name'];
		$image = substr($photoName, 0, -4).".jpg";
		move_uploaded_file($photo['tmp_name'], 'img/'.$image);
		resize('img/'.$image, 180); 
		$result = $user->uploadUserImage($conn, array($image, $id));
	}

	$result = $user->editUser($conn, array($name, $surname, $lastname, $email, $is_admin, $id));

	header("location: page_profile.php?id=$id");
}

if ($action == "edit_client_info") {
	$passport_number = trim($_POST['passport_number']);
	$birthday_date = $_POST['birthday_date'];
	$address = trim($_POST['address']);
	$card_number = trim($_POST['card_number']);

	$client = new Client($id, null, null);
	$result = $client->editClient($conn, array($passport_number, $birthday_date, $address, $card_number, $id));

	header("location: page_profile.php?id=$id");
}

function resize($image, $w_o = false, $h_o = false) {
	if (($w_o < 0) || ($h_o < 0)) {
		return false;
	}
	list($w_i, $h_i, $type) = getimagesize($image); 
	$types = array("", "gif", "jpeg", "png");
	$ext = $types[$type]; 
	if ($ext) {
		$func = 'imagecreatefrom'.$ext; 
	    $img_i = $func($image);
	} else {
		echo 'Некорректное изображение'; 
		return false;
	}
	if (!$h_o) $h_o = $w_o / ($w_i / $h_i);
	if (!$w_o) $w_o = $h_o / ($h_i / $w_i);
	$img_o = imagecreatetruecolor($w_o, $h_o); 
	imagecopyresampled($img_o, $img_i, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i); 
	$func = 'image'.$ext;
	return $func($img_o, $image); 
}

?>
	
	
	
	
		
	