<?php
print_r($_POST);
include_once('database/connection.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');

/*
update ao private -> JS for button
update ao titulo
update ao texto
update as tags -> outra tabela
update a data
update à imagem -> outra tabela 1 check if field sent

o que será + efeciente?
para texto fazer parse e subsituir
private é só um field
data same html already	 does as verificações
see if os Max(id) estão direito

verificar se os pares já existem e estão invisíveis para passar para viveis	
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


$delimiters="[\s,\/,\|]";
$tags=preg_split( "/".$delimiters."+/",$_POST["eventTags"] ); 
$tagsInEvent=getTagWithEvent($_POST['eventID']);
 $currentTagsInEventID=array();
 foreach($tagsInEvent as $tagInEvent){
		array_push( $currentTagsInEventID, $tagInEvent['tag_id']);
 }
$tagsAfterEdit=array();
 
print_r($tags);
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
				 echo "<br> TAG DESC:";
				createTag($tagDesc);
				$tagId=getLastTagId();
				print_r($tagId);
				createTagEvent($tagId,$_POST['eventID']); 
			}
			array_push($tagsAfterEdit,$tagId );

	}
	echo "OVER <br>";
			print_r($tagsAfterEdit);
			 echo "<br>";
			print_r($currentTagsInEventID);
	 $tagsToRemove = array_diff($currentTagsInEventID, $tagsAfterEdit);
		 
			echo "<br>TAGS to remove: ";
			print_r($tagsToRemove);
 foreach($tagsToRemove as $tag){
	updateTagEvents('visible','tag_id', $tag ,0);
} 

?>