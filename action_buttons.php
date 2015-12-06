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
		$reply = validateImageUpload();
		if($reply[0] == true){
			uploadImageFile("database/user_images/", "edit_user", $_SESSION['userID']);
		}

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

?>
