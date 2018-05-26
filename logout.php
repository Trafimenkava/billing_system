<?php 
session_start();
session_destroy();
setcookie('email', "", time() + 3600*24*7, "/", "localhost");
header("location: index.php");
?>
