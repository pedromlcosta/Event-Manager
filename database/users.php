<?php

function loginCorrect($username, $password){
	global $db;
	
	$query = "SELECT * FROM USERS WHERE username = ? AND password = ?";
	$stmt = $db->prepare($query);
	$stmt->execute(array($username, $password));
	
	// $stmt !== false means it found the user with the password
	return $stmt->fetch()!==false;
}
?>