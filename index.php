<?php
session_start();
require_once("php/Database.php");
require_once("php/QueryConsts.php");
require_once("php/User.php");

if (isset($_SESSION["email"]) || isset($_COOKIE["email"])) {
	header("location: home.php");
}

if(isset($_POST["login"])){
	if(!empty($_POST["email"]) && !empty($_POST["password"])) {
		$conn = DataBase::getConnection();
		$email = trim($_POST["email"]);
		$password = trim($_POST["password"]);
			
		$user = new User(null, null, $email);	
		$user  = $user->getUserByEmail($conn);			
		
		if($user->getUserId() != null) {
			if ($user->getUserRole() == 0) {
				$message = "Вы не наделены правами администратора, поэтому не можете войти в систему!";
			} else {
				$dbpassword = $user->getUserPassword();	 
				if (crypt($password, $dbpassword) == $dbpassword) {
					$_SESSION["email"] = $email;
					if (isset($_POST["remember"])) {
						setcookie("email", $email, time() + 3600*24*7, "/", "localhost");
					}
					header("location: home.php");	
				} else {
					$message = "Неверный пароль!";
				}
			}
		} else {
			$message = "Аккаунт " . $email . " не существует!";
		}			
	} else { 
		$message = "Заполните все поля!";
	} 
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Авторизация</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="icon" href="http://vladmaxi.net/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="http://vladmaxi.net/favicon.ico" type="image/x-icon">
</head>
<body>	
	<?php if (!empty($message)) {echo "<p style='background: red;' class='msg'>" . "ОШИБКА: ". $message . "</p>";} ?>
	<div id="container">
		<form action="" method="post">
			<label for="email">Email:</label><input type="email" name="email">
			<label for="password">Пароль:</label><input type="password" name="password">
			<div id="lower">
				<input type="checkbox" name="remember"><label class="check" for="checkbox">Запомнить меня</label>
				<input type="submit" name="login" value="Войти">
			</div>
		</form>
	</div>
</body>
</html>
	
	
	
	
	
		
	