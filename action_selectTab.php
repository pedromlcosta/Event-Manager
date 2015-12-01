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
        $result = getEventsUserAttending($_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters);
        break;
    case '#hostingEvents':
        $result = getEventsUserAttending(2,$order, $eventsPerPage, 1, array('Conference','lel', 'works'));
        break;
    case '#invitedEvents':
        $result = getEventsUserAttending(1,$order, $eventsPerPage, 1, array());
        break;
    case '#otherEvents':
        $result = getEventsUserAttending(1,$order, $eventsPerPage, 1, array());
        break;
    case '#customSearch':
        $result = getEventsUserAttending(1,$order, $eventsPerPage, 1, array());
        break;
    default:
        break;
	}
		
	}else{
		die();
	}

    echo json_encode($result);
?>
