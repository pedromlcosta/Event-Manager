<?php 
	include_once('init.php'); // connects to the database
	include_once('database/users.php');
	include_once('database/events.php');
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Event Manager</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/index.css">
		<link rel="icon" href="images/favicon.ico">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="script.js"></script>
	</head>

<?php
	include('templates/header.php');
 	include('templates/mainpage.php');      
  	include('templates/footer.php');
 ?>
