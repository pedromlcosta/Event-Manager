<?php
print_r($_POST['eventID']);

include_once('genericStart.html');	
include_once('init.php');

if(isset($_SESSION['errors'])){
	unset($_SESSION['errors']);

}
else if ( isset($_SESSION['userID']) && isset($_POST['title']) && isset($_POST['fullText']) && isset($_POST['data']) && isset($_POST['eventID']) && isset($_POST['Event_Type'])  ) {

include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/filters.php');
include_once('auxiliar.php');
/*
 
see if os Max(id) estão direito
check os gets por causa de o facto de o par de ids já existerem?
*/
	$errorMessage = '';
	global $destEventFolder;
    if(isset($_POST['private']))
    $privateValue=valiateCheckBox($_POST['private']);
    else
    $privateValue=0;

    $dataValid=validateDate($_POST['data']);
    $typeValid=validateTypes($_POST['Event_Type']);
    $imageValid=array(true);

    if(isset($_POST['eventImg']) && !empty($_POST['eventImg']) ){
		 $imageValid = validateImageUpload();
	} 
    
    $errorMessage= getErrorMessage(array($dataValid,$typeValid, $imageValid));
    if(strlen($errorMessage)==0){

	updateEvents('title',$_POST['eventID'],$_POST['title']);
	updateEvents('fulltext',$_POST['eventID'],$_POST['fullText']);
	updateEvents('data',$_POST['eventID'],$_POST['data']);
	updateEvents('private',$_POST['eventID'],$privateValue);
	updateEventsTypes($_POST['eventID'],getFilterId($_POST['Event_Type']));

 	if($imageValid[0]){
		 uploadImageFile($destEventFolder, 'edit_event', $_POST['eventID'])
	} 


  global $delimiters;
  
$tags=preg_split( "/".$delimiters."+/",$_POST["eventTags"] ); 
$tagsInEvent=getTagWithEvent($_POST['eventID']);
 $currentTagsInEventID=array();
 foreach($tagsInEvent as $tagInEvent){
		array_push( $currentTagsInEventID, $tagInEvent['tag_id']);
 }
$tagsAfterEdit=array();
 
	foreach($tags as $tagDesc){

		$tag=getTag($tagDesc);
		//print_r($tagDesc);
			if($tag){
				 
					$tagId=$tag['id'];
					if (!in_array( $tagId, $currentTagsInEventID)) {
						createTagEvent($_POST['eventID'],$tagId);
					}
			}
			else{
				//TODO parse para segurança e ignorar casos de erro like so um espaço
				if($tagDesc!='' && $tagDesc!=' '){
				echo "MOTHER FUCKER <br>";
				var_dump($tagDesc);
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
	}
	else{
		$_SESSION['errors']=$errorMessage;
	}
}
?>