<?php
	include_once('init.php'); //session_start + include(connection.php)
	include_once('database/users.php');
	include_once('database/events.php');

    $result = array();

	// REGISTER USER, IF VALID INFO
	if(isset($_POST['tab'])){

		switch ($_POST['tab']) {

    case 'link_myEvents':
        $result = array("Tab1");
        break;
    case 'link_hostingEvents':
        $result = array("Tab2");
        break;
    case 'link_invitedEvents':
        $result = array("Tab3");
        break;
    case 'link_otherEvents':
        $result = array("Tab4");
        break;
    case 'link_customSearch':
        $result = array("Tab5");
        break;
    default:
        break;
	}
		
	}else{
		die();
	}
	
	echo json_encode($result);
?>
