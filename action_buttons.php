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
			changeAttendingStatus($_POST['eventID'], $_POST['userID'],1);

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
	 
	 // CHANGE FULLNAME
	if ($_POST['action']=='CHANGE_USER_FULLNAME' ) {

		$result=updateUser('fullname','password',$_POST['newName'],$_POST['password'],$_SESSION['userID']);

		if(!$result)
			$reply = array(false, 'Wrong Password');

		$reply[0] = $result;

	}else if ($_POST['action']=='CHANGE_USER_PASSWORD' ) {

		if($_POST['confirmPass'] != $_POST['newPass']){
			$reply = array(false, "New Password doesn't match with confirmation");
		}else if(strlen($_POST['oldPass']) < 6){
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
