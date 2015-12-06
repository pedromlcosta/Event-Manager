<?php
	include_once('init.php'); //session_start + include(connection.php)
	include_once('database/users.php');
	include_once('database/events.php');
    include_once('database/comments.php');
    require_once("ESAPI/src/ESAPI.php");
    require_once("ESAPI/src/reference/DefaultEncoder.php");
    
    $result = array();
     
    if(isset($_SESSION['currentEventPage'])){
        $eventID = $_SESSION['currentEventPage'];
    }

	// REGISTER USER, IF VALID INFO
	if(isset($_POST['action'])){
        $ESAPI = new ESAPI("ESAPI/test/testresources/ESAPI.xml");
        if(isset($_POST['comment'])){
              
             $comment = $ESAPI->getEncoder()->encodeForHTML($_POST['comment']); 
        }

        $commentsPerPage = $_POST['commentsPerPage'];
        $page = $_POST['page'];
    
	switch ($_POST['action']) {
    case 'addComment':
        // Query the comments here
        if($comment != ''){

            addCommentToEvent($eventID, $_SESSION['userID'], $comment);
        }
        $result = getEventComments($eventID, $commentsPerPage, $page);        
        break;
    case 'reload':
        // Query the comments here
        $result = getEventComments($eventID, $commentsPerPage, $page);         
        break;
    default:
        break;
	}
		
	}else{
		die();
	}

    echo json_encode($result);
?>
