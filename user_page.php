<?php 
	include_once('init.php'); // connects to the database
	include_once('database/users.php');
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Event Manager</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/index.css">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<style type="text/css"></style>
	</head>

<?php
	include('templates/header.php');
 	include('templates/user_page.php');      
  	include('templates/footer.php');
 ?>
