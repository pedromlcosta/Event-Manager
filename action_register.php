<?php
	session_start();

	include_once("database/connection.php");
	include_once('database/users.php');

	$target_dir = "database/user_images/";
	//TODO: User can put image or not

	
	$_SESSION['registerStatus'] = registerUser($_POST['username'],$_POST['password'],$_POST['fullname']);


	// IMAGE UPLOADING

	$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
	$target_file = $target_dir . basename($_POST['username']) . "." . $imageFileType;
	$uploadOk = 1;
	

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
   		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   		if($check !== false) {
        	//echo "File is an image - " . $check["mime"] . ".";
        	$uploadOk = 1;
    	} else {
        	//echo "File is not an image.";
        	$uploadOk = 0;
    	}
	}
	
	// Finally moving image to folder
	if($_SESSION['registerStatus'] == "REGISTERED SUCCESSFULLY."){
		if($uploadOk){
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
		}else{
			$_SESSION['registerUpload'] = "ERROR UPLOADING IMAGE.";
		}
	}	

header("Location: ".$_SERVER['HTTP_REFERER']);
?>
