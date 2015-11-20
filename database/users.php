<?php

function loginCorrect($username, $password){
	global $db;

	try{
	$query = "SELECT * FROM USERS WHERE username = ? AND password = ?";
	$stmt = $db->prepare($query);
	$stmt->execute(array($username, $password));
	
	// $stmt !== false means it found the user with the password
	return $stmt->fetch()!==false;
	}catch(PDOException $e){
		echo $query . "<br>" . $e->getMessage();
	}

}

function registerUser($username, $password){
	global $db;
	
	//No restrictions, as of yet.

	try {
		
	$stmt = $db->prepare("SELECT * FROM USERS WHERE username = ?");
	$stmt->execute(array($username));
	
	
	if($stmt->fetch() !== false){
		return "A USERNAME WITH THAT NAME ALREADY EXISTS.";
	}
	
	$query = "INSERT INTO USERS (username, password) VALUES(?, ?)";
	$stmt = $db->prepare($query);
	$stmt->execute(array($username, $password));
	
	return "REGISTERED SUCCESSFULLY.";
	}catch(PDOException $e){
		echo $query . "<br>" . $e->getMessage();
		return "ERROR REGISTERING.";
	}
}

?>
