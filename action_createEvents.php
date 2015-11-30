<?php
include_once('genericStart.html');
include_once('init.php'); // connects to the database
include_once('database/users.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/usersEvent.php');

 if (isset($_SESSION['userID']) && isset($_POST['title']) && isset($_POST['fullText']) && isset($_POST['data']) && isLogged() ) {
			//print_r($_POST);
			$privateValue;
			if(!isset($_POST['private']))
				$privateValue=0;
			else
				$privateValue=parseCheckBox($_POST['private']);
			
			 global $delimiters ;
			if(createEvent($_POST['title'],$_POST['fullText'],$privateValue,$_POST['data'] ,$_SESSION['userID'])) {
						 $eventCreatedId=getLastEventId();
						 $userId=$_SESSION['userID'] ;
						 addUserToEvent($eventCreatedId['id'], $userId);
						  $tags=preg_split( "/".$delimiters."+/",$_POST["eventTags"] ); 
						  foreach ($tags as $tagDesc) {
					 
						   	$tagId=createTag($tagDesc);
						   	if($eventCreatedId)
						  	createTagEvent($eventCreatedId['id'],$tagId);

						}
			  } 
			  //TODO falta acrescentar as tretas do path e isso
			  /*$image=getImageByPath($_POST['image']);
				if(!$image){
					createImage($_POST['image']);
					$imageId=getLastimageId();
				} 
				else{
					$imageId=$image['id'];
				}
				createImageEvent($eventCreatedId['id'],$imageId);*/
	 }

		   function parseCheckBox($value){
		   	if($value=='on')
		   		return 1;
		   	else 
		   		return 0;

		   }

   include_once("templates/footer.php");
?>