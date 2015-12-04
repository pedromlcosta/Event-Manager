<?php

include_once('init.php');
include_once('database/usersEvent.php');
include_once('database/events.php');
include_once('database/tagEvent.php');
if(isset($_POST) && (!empty($_POST)) && isset($_POST['action']) && isset($_POST['userID']) && isset($_POST['eventID']) ) {


	if($_POST['action']=='JOIN' ) {
		changeAttendingStatus($_POST['eventID'], $_POST['userID'],1);
		echo json_encode(true);
	}
	else
		if($_POST['action']=='REMOVE' ) {
		removeUserFromEvent($_POST['eventID'], $_POST['userID']);
		echo json_encode(true);
	}
	else
		if($_POST['action']=='LEAVE' ) {
		changeAttendingStatus($_POST['eventID'], $_POST['userID'],0);
		echo json_encode(true);
	}
	else
		if($_POST['action']=='DELETE' ) {
		deleteEvent($_POST['eventID']);
		//removeTagEventsByEvent($_POST['eventID']);

		echo json_encode(true);
	}

}

?>