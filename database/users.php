<?php

function loginAccount($username, $password){
	global $db;

	try{
	$query = "SELECT * FROM USERS WHERE username = ? COLLATE NOCASE AND password = ?";
	$stmt = $db->prepare($query);
	$stmt->execute(array($username, sha1($password)));
	$result = $stmt->fetch();

	// $result !== false means it found the user with the password
	if($result !== false){
		$_SESSION['userID'] = $result['id'];
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

function updateUserName($field,$newName,$userID){
	//security input?
	$queryPart1='UPDATE users SET'; 
	$quertPart2=' = ';
	$quertPart3=' WHERE users.id = ?';
	$query=$queryPart1.$field.$newName.$quertPart3;
	$stmt = $db->prepare($query);
	$stmt->execute(array($userID));

}

