 <?php
  include_once('database/connection.php');
  include_once('database/tag.php');
  include_once('database/tagEvent.php');
  include_once('database/events.php');

  $delimiters="[\s,\/,\|]";
  $searchResults= array();
  $tags=preg_split( "/".$delimiters."+/",$_POST["tagsToSearch"] ); 
  $tagsToSearch=array();

  print_r($_POST);
 foreach( $tags as $toSearch){
  $tempTag=getTagId($toSearch);
    if($tempTag)
      array_push($tagsToSearch,$tempTag);
  }
  
    $searchResults=getEventsWithAnd($tagsToSearch);
    $searchResultsOR=getEventsWithOr($tagsToSearch);

    if($searchResultsOR){
      $searchResults= array_uintersect($searchResults, $searchResultsOR,'compareEvents');
    } 

    print_r($searchResults);
    echo "<br>";

  if(!empty($searchResults)){
       if(!empty($_POST['dateTag'])){
            $eventsWithDate=getEventByDate($_POST['dateTag']);
            if($eventsWithDate)
              $searchResults=  array_uintersect($searchResults, $eventsWithDate,'compareEvents'); 
            else
              array_splice( $searchResults,0);
          }
       
      include_once("templates/list_search_results.php");
    }
     function compareEvents($tagEvent,$tagEvent1){
        return ($tagEvent['id']==$tagEvent1['id']);
   }
?>
 