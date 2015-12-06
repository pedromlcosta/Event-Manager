<?php 
	include_once('init.php'); // connects to the database
	include_once('database/users.php');
	include_once('database/events.php');
	require_once("ESAPI/src/ESAPI.php");
 	require_once("ESAPI/src/reference/DefaultEncoder.php");
	include_once('genericStart.html');
?>
<script src="scripts/users.js"></script>
<?php
	include_once('templates/header.php');
 	include_once('templates/user_page.php');      
  	include_once('templates/footer.php');
 ?>
