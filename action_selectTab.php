<?php
	include_once('init.php'); //session_start + include(connection.php)
	include_once('database/users.php');
	include_once('database/events.php');
    include_once('database/tag.php');
    include_once('database/tagEvent.php');
    include_once('database/usersEvent.php');
    include_once('database/filters.php');
 
//TODO check the permission stuff,provavelmente vou ter de adecionar à query no big deal,just one more select etc...
//TODO THE SPLICE E DIVIDIR POR PÀGINA E COUNT E ISSO
// add to get event Owner e pic url 
    $result = array();

	// REGISTER USER, IF VALID INFO
	if(isset($_POST['tab'])){

    //Arrived in JSON form, turn into array again
    $typeFilters = json_decode($_POST['typeFilters']);
     $dateTag="";
     $userProvidedTags ="";
     if(isset($_POST['dateTag']) ) {
        $dateTag =$_POST['dateTag'];
    }
    if(isset($_POST['userProvidedTags'] )) {
        $userProvidedTags = $_POST['userProvidedTags'];
    }
    $eventsPerPage = $_POST['eventsPerPage'];
    $page = $_POST['page'];
    $order = $_POST['order'];

    
	switch ($_POST['tab']) {
    case '#hostingEvents':
        // Done
        $result = getEventsUserHosting($_SESSION['userID'], $_SESSION['userID'], $order, $eventsPerPage, $page, $typeFilters, 0);
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
        if(isLogged()){
            $user = $_SESSION['userID'];
        }else{
            $user = null;
        }
        $result = customSearch($user,$userProvidedTags,$dateTag,$typeFilters,$order, $eventsPerPage, $page);
        break;
    case '#hostedPublic':
        if(isLogged()){
            $permission = 1;
            $userWatching = $_SESSION['userID'];
        }else{
            $permission = 2;
            $userWatching = null;
        }
        $result = getEventsUserHosting($_SESSION['currentUserPage'], $userWatching, $order, $eventsPerPage, $page, $typeFilters, $permission);
        break;
    default:
        break;
	}
		
	}else{
		die();
	}

    echo json_encode($result);
?>
