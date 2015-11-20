<?php
	session_start();

	include_once('database/connection.php');
	include_once('database/users.php');


	$_SESSION['registerStatus'] = registerUser($_POST['username'],$_POST['password']);
		

header("Location: ".$_SERVER['HTTP_REFERER']);
?>
