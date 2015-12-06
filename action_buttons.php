<?php
include_once('init.php');
include_once('database/usersEvent.php');
include_once('database/events.php');
include_once('database/tagEvent.php');
include_once('database/users.php');


if(isset($_POST) && (!empty($_POST)) && isset($_POST['action']) ) {

	$reply = array(true, "Success");

	if ( isset($_POST['userID']) && isset($_POST['eventID'])) 
	{
		if($_POST['action']=='JOIN' ) {
			$reply=changeAttendingStatus($_POST['eventID'], $_POST['userID'],1);
			if($reply===false)
				addUserToEvent($_POST['eventID'],$_POST['userID']);
			}
		else if($_POST['action']=='REMOVE' ) {
			removeUserFromEvent($_POST['eventID'], $_POST['userID']);
			}
		else if($_POST['action']=='LEAVE' ) {
			changeAttendingStatus($_POST['eventID'], $_POST['userID'],0);
			}
		else if($_POST['action']=='DELETE' ) {
			deleteEvent($_POST['eventID']);
			//removeTagEventsByEvent($_POST['eventID']);

		}
	}
	 
	// USER PAGE ACTIONS

	 	// CHANGE FULLNAME
	if ($_POST['action']=='CHANGE_USER_IMAGE' ) {

		//Change images already returns the array with false/true and error message
		$reply = uploadImageFile(false, "database/user_images/", "user", $_SESSION['userID']);
		
	}else if ($_POST['action']=='CHANGE_USER_FULLNAME' ) {

		$result=updateUser('fullname','password',$_POST['newName'],$_POST['password'],$_SESSION['userID']);

		if(!$result)
			$reply = array(false, 'Wrong Password');

		$reply[0] = $result;
		
		// CHANGE PASSWORD
	}else if ($_POST['action']=='CHANGE_USER_PASSWORD' ) {

		if($_POST['confirmPass'] != $_POST['newPass']){
			$reply = array(false, "New Password doesn't match with confirmation");
		}else if(strlen($_POST['newPass']) < 6){
			$reply = array(false, "New password must have 6 or more characters");
		}else{

	 	$result = updateUser('password','password',$_POST['newPass'],$_POST['oldPass'],$_SESSION['userID']);
	 	
		if(!$result)
			$reply =  array(false, "Wrong Password");
		
		}
	}	

	echo json_encode($reply);
}


function uploadImageFile($validateOnly, $destinationFolder, $user_or_event, $rowID){
	//return $_FILES["imageToUpload"];
	
	if(!isset($_FILES["fileToUpload"])){

		return array(false, "No Image Input Found");

	}else{
		// CHECK POSSIBLE ERRORS
		$error = $_FILES["fileToUpload"]['error'];
		
			switch ($error) {
   		case 0:
        	// OK: do Nothing
        	break;
    	case 4:
        	return array(false, "No Image Selected");
        	break;
    	case 1:
        	return array(false, "Max Upload Size Exceeded");
        	break;
        case 2:
        	return array(false, "Max Upload Size Exceeded 2");
        	break;
        case 3:
        	return array(false, "Error Uploading: File uploaded partially");
        	break;
        case 7:
        	return array(false, "Error Uploading: Server failed to upload");
        	break;
        case 7:
        	return array(false, "Error Uploading: An extension stopped the upload");
        	break;
        default:
        	break;
			}
	
	}
	
	// FURTHER MANUAL CHECKS
	if($_FILES["fileToUpload"]["name"] != ''){

		// CHECKING IF FILE IS REALLY AN IMAGE		
   		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   		if($check === false) {
        	return array(false, "The uploaded file is not an image");
    	}

    	$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
    	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    		return array(false, "Only Valid image types are allowed");
		}

    	 // CHECKING FILE SIZE
		if ($_FILES["fileToUpload"]["size"] > 64000000) {
    		return array(false, "Max File Size exceeded");
		}
	}

	if(!$validateOnly){

		$target_dir = $destinationFolder;

		// CREATING PSEUDO-RANDOM NAME FOR FILE
		$imageFileName = bin2hex(openssl_random_pseudo_bytes(32));
		$target_file = $target_dir . $imageFileName . "." . $imageFileType;
	
		while(file_exists($target_file)){
			$imageFileName = bin2hex(openssl_random_pseudo_bytes(32));
			$target_file = $target_dir . $imageFileName . "." . $imageFileType;
		}
		
		// Save on DB
		if($user_or_event == 'user'){
			changeUserImage($rowID, $target_file);
		}else{

		}
	
		// Move to folder
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
	}
	
	// REACHED THIS = PASSED ALL ERROR TESTS
	return array(true, "Success");	
}


?>
