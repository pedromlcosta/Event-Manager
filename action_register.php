<?php
	include_once('init.php'); //session_start + include(connection.php)
	include_once('database/users.php');

	//TODO: Make safer

	$registerStatus = '';
	$target_dir = "database/user_images/";


	// REGISTER USER, IF VALID INFO
	if(isset($_POST['username'])){
		if($_POST['username'] == '' OR $_POST['password'] == '' OR $_POST['fullname'] == ''){
			$registerStatus = "EMPTY REGISTER FIELDS";
			echo $_POST['password'];
		}else{

		$registerStatus = registerUser($_POST['username'],$_POST['password'],$_POST['fullname']);
		}
	}else{
		die();
	}
	

	// CHECK IF IMAGE IS VALID
	$uploadOk = 0;

	if($_FILES["fileToUpload"]["name"] != ''){

		$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
		$target_file = $target_dir . basename($_POST['username']) . "." . $imageFileType;
	
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
   			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   			if($check !== false) {
        		//echo "File is an image - " . $check["mime"] . ".";
        		$uploadOk = 1;
    		}
		}
	}


	// UPLOAD IMAGE, IF VALID
	if($registerStatus == "REGISTERED SUCCESSFULLY."){
		if($uploadOk){
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
		}else{
			$registerStatus = $registerStatus. " NO IMAGE UPLOADED.";
		}
	}	
	echo $registerStatus;
?>
