<?php

	session_start();

	include_once("database/connection.php");
	include_once("database/users.php");

	if(!isset($_POST['username'])){
		die();
	}

	if(loginAccount($_POST['username'], $_POST['password'])){
		echo "true";
	}else{
		echo "false";
	}
?>
