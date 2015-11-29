<?php
	include_once('init.php'); //session_start + include(connection.php)
	include_once('database/users.php');
	include_once('database/events.php');

    $result = array();

	// REGISTER USER, IF VALID INFO
	if(isset($_POST['tab'])){

		switch ($_POST['tab']) {

    case 'link_myEvents':
        $result = getEventsUserAttending(1,'date', 10, 1);
        break;
    case 'link_hostingEvents':
        $result = getEventsUserAttending(1,'date', 5, 0);
        break;
    case 'link_invitedEvents':
        $result = getEventsUserAttending(1,'date', 5, 0);
        break;
    case 'link_otherEvents':
        $result = getEventsUserAttending(1,'date', 5, 0);
        break;
    case 'link_customSearch':
        $result = getEventsUserAttending(1,'date', 5, 0);
        break;
    default:
        break;
	}
		
	}else{
		die();
	}
	
	echo json_encode($result);
?>
