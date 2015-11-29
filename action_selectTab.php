<?php
	include_once('init.php'); //session_start + include(connection.php)
	include_once('database/users.php');
	include_once('database/events.php');


	// REGISTER USER, IF VALID INFO
	if(isset($_POST['tab'])){

		switch ($_POST['tab']) {
    case 1:
        $result = array("Tab1");
        break;
    case 2:
        $result = array("Tab2");
        break;
    case 3:
        $result = array("Tab3");
        break;
    case 4:
        $result = array("Tab4");
        break;
    case 5:
        $result = array("Tab5");
        break;
	}
		
	}else{
		die();
	}
	
	echo json_encode($result);
?>
