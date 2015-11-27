<?php
include_once('database/connection.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/users.php');
include_once('database/usersEvent.php');

//if (isset($_SESSION) && isset($_SESSION['username'])) {
		if(isset($_POST['submit'])) 
		{
			//print_r($_POST);
			$privateValue;
			if(!isset($_POST['private']))
				$privateValue=0;
			else
				$privateValue=parseCheckBox($_POST['private']);
			
			//$_SESSION['username']
			  $delimiters="[\s,\/,\|]";
			if(createEvent($_POST['title'],$_POST['fullText'],$privateValue,$_POST['data'] ,"Filipe")) {
						 $eventCreatedId=getLastEventId();
						 //$_SESSION['username']
						 $userId=getUserId("Filipe");
						 addUserToEvent($eventCreatedId['id'], $userId);
						  $tags=preg_split( "/".$delimiters."+/",$_POST["eventTags"] ); 
						  foreach ($tags as $tagDesc) {
						  	//print_r($tagDesc);
						  	//print_r($eventCreatedId );
						   	$tagId=createTag($tagDesc);
						   	if($eventCreatedId)
						  	createTagEvent($eventCreatedId['id'],$tagId);

						}
			  } 
		}
		 
		//}

		   function parseCheckBox($value){
		   	if($value=='on')
		   		return 1;
		   	else 
		   		return 0;

		   }
?>