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
    case '#hostingEvents':
        // Done
        $result = getEventsUserHosting($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters);
        break;
    case '#myEvents':
        // Done
        $result = getEventsUserAttending($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters, 1);
        break;
    case '#invitedEvents':
        // Done
        $result = getEventsUserAttending($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters, 0);
        break;
    case '#otherEvents':
        // Done
        $result = getAllVisibleEvents($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters);
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
