<?php
include_once('database/connection.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/users.php');
include_once('database/usersEvent.php');

//if (isset($_SESSION) && isset($_SESSION['username'])) {
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
					 
						   	$tagId=createTag($tagDesc);
						   	if($eventCreatedId)
						  	createTagEvent($eventCreatedId['id'],$tagId);

						}
			  } 
			  //falta acrescentar as tretas do path e isso
			  $image=getImageByPath($_POST['image']);
				if(!$image){
					createImage($_POST['image']);
					$imageId=getLastimageId();
				} 
				else{
					$imageId=$image['id'];
				}
				createImageEvent($eventCreatedId['id'],$imageId);
		//}

		   function parseCheckBox($value){
		   	if($value=='on')
		   		return 1;
		   	else 
		   		return 0;

		   }
?>