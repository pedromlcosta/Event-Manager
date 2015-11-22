<?php

session_start();

include_once("database/connection.php");
include_once("database/users.php");

if(!loginCorrect($_POST['username'], $_POST['password'])){
	$_SESSION['loginFailed'] = true;
}

header("Location: ".$_SERVER['HTTP_REFERER']);
?>