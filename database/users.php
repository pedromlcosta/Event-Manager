<?php

function loginAccount($username, $password){
	global $db;

	try{
	$query = 'SELECT * FROM USERS WHERE username = ?  ';//  COLLATE NOCASE AND password = ?";
	$stmt = $db->prepare($query);
	$stmt->execute(array($username));
	$user = $stmt->fetch();
	$result=password_verify($password,$user['password']);
 
	// $result !== false means it found the user with the password
	if($result !== false){
		$_SESSION['userID'] = $user['id'];
		return true;
	}else{
		return false;
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
	$stmt->execute(array($username, password_hash($password,PASSWORD_DEFAULT), $fullname));
	
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

function getUser($username){

   global $db;
  $stmt = $db->prepare('SELECT * FROM users WHERE username= ?');
  $stmt->execute(array($username));  
  return $stmt->fetch();
}

function getUserId($username){
	$user=getUser($username);

	if($user)
		return $user['id'];
	else
		return false;
}

function getUserFullname($userID){
	global $db;

  $stmt = $db->prepare('SELECT fullname FROM users WHERE id= ?');
  $stmt->execute(array($userID));

  return $stmt->fetch()['fullname'];
}

function getUserIDFull($userFullname){
	global $db;

  $stmt = $db->prepare('SELECT id FROM users WHERE fullname= ?');
  $stmt->execute(array($userFullname));

  return $stmt->fetch()['id'];
}

// Returns image URL for the user specified
// If user does not have an image, returns NULL
function getUserImageURL($userID){
	global $db;

	$stmt = $db->prepare('SELECT DISTINCT images.url FROM users, images, users_images WHERE users_images.user_id = ? AND users_images.image_id = images.id');
	$stmt->execute(array($userID));
 	
 	$result = $stmt->fetch()['url'];

 	if($result === null)
 		return 'images/default_profile_pic.jpg';
 	else
 		return $result;
}

function updateUser($fieldChange,$fieldCheck,$fieldChangeValue,$fieldCheckValue,$userID){
	//security input?
	global $db;
	
	// Verify Password
	$fieldCheckValue = password_hash($fieldCheckValue,PASSWORD_DEFAULT);
	//ou podemos fazer
	/*
		SELECT password e depois usar o boolean password_verify ( string $password , string $hash )
	*/
	$query = "SELECT  $fieldCheck AS field FROM users WHERE id = ? ";
	$stmt = $db->prepare($query);
	$stmt->execute(array($userID, ));
	$result = $stmt->fetch();

	if(password_verify($result['field'],$fieldCheckValue)){
		return false;
	}else{

		if($fieldChange == 'password')
			$fieldChangeValue = password_hash($fieldChangeValue,PASSWORD_DEFAULT);

		$query = "UPDATE users SET $fieldChange = ? WHERE users.id = ? AND visible = 1";
		$stmt = $db->prepare($query);
		$result= $stmt->execute(array($fieldChangeValue,$userID));

		return true;
	}
}?>