<?php
print_r($_POST);

if(!isset($_POST)){
include_once('init.php');
include('templates/header.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('auxiliar.php');

/*
update ao private -> JS for button
update à imagem -> outra tabela 1 check if field sent

o que será + efeciente?
para texto fazer parse e subsituir
private é só um field
 
see if os Max(id) estão direito
check os gets por causa de o facto de o par de ids já existerem?
*/
updateEvents('title',$_POST['eventID'],$_POST['title']);
updateEvents('fulltext',$_POST['eventID'],$_POST['fullText']);
updateEvents('data',$_POST['eventID'],$_POST['data']);


	if(isset($_POST['eventImg'])){
		$imageExists=getImageByPath($_POST['eventImg']);
		if($imageExists){
			$imageId=$imageExists['id'];

		}
		else{
			createImage($_POST['eventImg']);
			$imageId=getLastimageId()['id'];

		}
		createImageEvent($_POST['eventID'],$imageId);
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
		print_r($tagDesc);
		echo " 1 ";
			if($tag){
				 
					$tagId=$tag['id'];
					if (!in_array( $tagId, $currentTagsInEventID)) {
						createTagEvent($tagId,$_POST['eventID']);
					}
			}
			else{
				//TODO parse para segurança e ignorar casos de erro like so um espaço
				createTag($tagDesc);
				$tagId=getLastTagId();
				createTagEvent($tagId,$_POST['eventID']); 
			}
			array_push($tagsAfterEdit,$tagId );

	}
	 
	 $tagsToRemove = array_diff($currentTagsInEventID, $tagsAfterEdit);
		  
 	foreach($tagsToRemove as $tag){
		removeTagEvents($tag);
}

}
   include_once("templates/footer.php");
?>