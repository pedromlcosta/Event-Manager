<?php
include_once('init.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/filters.php');
include_once('auxiliar.php');

if ( isset($_SESSION['userID']) && isset($_POST['title']) && isset($_POST['fullText']) && isset($_POST['data']) && isset($_POST['eventID']) && isset($_POST['Event_Type'])  ) {

	global $delimiters;

	$errorMessage = '';
    $eventCreatedId = $_POST['eventID'];
    $createOK = false;

    if(isset($_POST['private']))
    	$privateValue=validateCheckBox($_POST['private']);
    else
    	$privateValue=0;


    $dataValid=validateDate($_POST['data']);
    $typeValid=validateTypes($_POST['Event_Type']);
    $imageValid=array(true);

    // Checks validity of file uploaded, if any
    if(isset($_FILES['fileToUpload']) && !empty($_FILES['fileToUpload']) ){
		 $imageValid = validateImageUpload();
	} 
    
	// Creates error message. If no file was selected, ignores any file errors
	// Only appends image error if validation went wrong and an error ocurred
	$errorMessage= getErrorMessage(array($dataValid,$typeValid));
    if($_FILES["fileToUpload"]['error'] != 4 && !$imageValid[0] ){
    	$errorMessage=$errorMessage.$imageValid[1]. "<br>";
    }
    
 
    if(strlen($errorMessage) == 0){

		updateEvents('title',$_POST['eventID'],$_POST['title']);
		updateEvents('fulltext',$_POST['eventID'],$_POST['fullText']);
		updateEvents('data',$_POST['eventID'],$_POST['data']);
		updateEvents('private',$_POST['eventID'],$privateValue);
		updateEventsTypes($_POST['eventID'],getFilterId($_POST['Event_Type']));
		$createOk = true;

 		if($_FILES["fileToUpload"]['error'] != 4 && $imageValid[0]){
 			uploadImageFile("images/", 'edit_event', $_POST['eventID']);
		} 
    
  
		$tags=preg_split( "/".$delimiters."+/",$_POST["eventTags"] ); 
		$tagsInEvent=getTagWithEvent($_POST['eventID']);
		$currentTagsInEventID=array();
	
		foreach($tagsInEvent as $tagInEvent){
			array_push( $currentTagsInEventID, $tagInEvent['tag_id']);
		}

		$tagsAfterEdit=array();
 
		foreach($tags as $tagDesc){

			$tag=getTag($tagDesc);
			
			if($tag){
				 
					$tagId=$tag['id'];
					
					if (!in_array( $tagId, $currentTagsInEventID)) {
						createTagEvent($_POST['eventID'],$tagId);
					}
			}
			else{
				
				if($tagDesc!='' && $tagDesc!=' '){
				createTag($tagDesc);
				$tagId=getLastTagId();
				createTagEvent($_POST['eventID'],$tagId); 
				}
			}
			
			array_push($tagsAfterEdit,$tagId );
		} 

		$tagsToRemove = array_diff($currentTagsInEventID, $tagsAfterEdit);
 
		foreach($tagsToRemove as $tag){
			removeTagEvents($tag);
		}

		$createOK = true;	
	}

	echo json_encode(array($createOK, $errorMessage, $eventCreatedId));
}
?>