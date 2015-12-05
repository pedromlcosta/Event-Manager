<?php

include_once('init.php');
include_once('database/usersEvent.php');
include_once('database/events.php');
include_once('database/tagEvent.php');
include_once('database/users.php');
if(isset($_POST) && (!empty($_POST)) && isset($_POST['action']) ) {

	$reply;
	if ( isset($_POST['userID']) && isset($_POST['eventID'])) 
	{
		if($_POST['action']=='JOIN' ) {
			changeAttendingStatus($_POST['eventID'], $_POST['userID'],1);
			echo json_encode(array(true));
		}
		else
			if($_POST['action']=='REMOVE' ) {
			removeUserFromEvent($_POST['eventID'], $_POST['userID']);
			echo json_encode(array(true));
		}
		else
			if($_POST['action']=='LEAVE' ) {
			changeAttendingStatus($_POST['eventID'], $_POST['userID'],0);
			echo json_encode(array(true));
		}
		else
			if($_POST['action']=='DELETE' ) {
			deleteEvent($_POST['eventID']);
			//removeTagEventsByEvent($_POST['eventID']);
	
			echo json_encode(array(true));
		}
	}
	 
		if ($_POST['action']=='CHANGE_USER_FULLNAME' ) {
		$result=updateUser($_POST['oldName'],$_POST['newName'],'fullname','fullname',$_POST['userID']);

		if($result)
			$reply= 'Success';
		else
			$reply= 'Full Name does not exist' ;

	}
		else
		if ($_POST['action']=='CHANGE_USER_PASSWORD' ) {
	 	$result=	updateUser($_POST['oldPass'],$_POST['newPass'],'password','password',$_POST['userID']);

		if($result)
			$reply= "Success" ;
		else
			$reply= "Insert Correct Password";
	}
	echo $reply;

}

?>