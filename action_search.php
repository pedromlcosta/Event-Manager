 <?php
  include_once('database/connection.php');
  include_once('database/tag.php');
  include_once('database/tagEvent.php');
  include_once('database/events.php');

  $delimiters="[\s,\/|]";
  $searchResults= array();
  $tags=preg_split( "/".$delimiters."+/",$_POST["tagsToSearch"] ); 
  if(!empty($_POST['dateTag'])){
    array_push($tags, $_POST['dateTag']);
}
 
 foreach( $tags as $toSearch){

  $tempTag=getTag($toSearch);

    if($tempTag){

        $eventsWithTempTag=getEventWithTag($tempTag['id']);

        if(empty($searchResults)){
          $searchResults=$eventsWithTempTag;
      }
    else{  
        $searchResults=  array_uintersect($searchResults, $eventsWithTempTag,'compareEvents');
      }
    }
 }
     function compareEvents($tagEvent,$tagEvent1){
      return ($tagEvent['event']==$tagEvent1['event']);
 }
 
    include_once("templates/list_search_results.php");

    
?>
 