<?php 
	session_start();

	include_once('database/connection.php'); // connects to the database
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Event Manager</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/index.css">
		<style type="text/css"></style>
	</head>

<?php
	include('templates/header.php');
 	include('templates/mainpage.php');      
  	include('templates/footer.php'); 
?>
