<?php

function loginCorrect($username, $password){
	global $db;

	try{
	$query = "SELECT * FROM USERS WHERE username = ? COLLATE NOCASE AND password = ?";
	$stmt = $db->prepare($query);
	$stmt->execute(array($username, sha1($password)));
	$result = $stmt->fetch();

	// $result !== false means it found the user with the password
	if($result !== false){
		$_SESSION['username'] = $result['username'];
		$_SESSION['fullname'] = $result['fullname'];
		//$_SESSION['userimage'] = "database/user_images".$result['username'];
		$_SESSION['userimage'] = "database/user_images/username2.jpg";
	}

	}catch(PDOException $e){
		echo $query . "<br>" . $e->getMessage();
	}catch(DatabaseException $e){
		echo "Unexpected Database Error: " . $e->getMessage();
		return "ERROR LOGGING IN.";
	}catch(Exception $e){
		echo "Unexpected Database Error: " . $e->getMessage();
		return "ERROR LOGGING IN.";
	}

}

function registerUser($username, $password, $fullname){
	global $db;
	
	//No restrictions, as of yet.

	try {
		
	$stmt = $db->prepare("SELECT * FROM USERS WHERE username = ? COLLATE NOCASE");
	$stmt->execute(array($username));
	
	
	if($stmt->fetch() !== false){
		return "A USERNAME WITH THAT NAME ALREADY EXISTS.";
	}
	
	$query = "INSERT INTO USERS (username, password, fullname) VALUES(?, ?, ?)";
	$stmt = $db->prepare($query);
	$stmt->execute(array($username, sha1($password), $fullname));
	
	//TODO: Change hardcoded returns to numbers. Map numbers to each string
	return "REGISTERED SUCCESSFULLY.";
	}catch(PDOException $e){
		echo $query . "<br>" . $e->getMessage();
		return "ERROR REGISTERING.";
	}catch(DatabaseException $e){
		echo "Unexpected Database Error: " . $e->getMessage();
		return "ERROR REGISTERING.";
	}catch(Exception $e){
		echo "Unexpected Database Error: " . $e->getMessage();
		return "ERROR REGISTERING.";
	}
}

?>
