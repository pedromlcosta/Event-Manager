<?php

	include_once('init.php');
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
