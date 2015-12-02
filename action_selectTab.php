<?php
	include_once('init.php'); //session_start + include(connection.php)
	include_once('database/users.php');
	include_once('database/events.php');

    $result = array();

	// REGISTER USER, IF VALID INFO
	if(isset($_POST['tab'])){

    //Arrived in JSON form, turn into array again
    $typeFilters = json_decode($_POST['typeFilters']);

    $eventsPerPage = $_POST['eventsPerPage'];
    $page = $_POST['page'];
    $order = $_POST['order'];

	switch ($_POST['tab']) {
    case '#myEvents':
        $result = getEventsUserAttending($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters, 1);
        break;
    case '#hostingEvents':
        // Done
        $result = getEventsUserAttending($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters, 1);
        break;
    case '#invitedEvents':
        // Done
        $result = getEventsUserAttending($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters, 0);
        break;
    case '#otherEvents':
        $result = getEventsUserAttending($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters, 1);
        break;
    case '#customSearch':
        $result = getEventsUserAttending($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters, 1);
        break;
    default:
        break;
	}
		
	}else{
		die();
	}

    echo json_encode($result);
?>
