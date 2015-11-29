 <?php
  include_once('init.php');
  include_once('templates/header.php');
  include_once('database/tag.php');
  include_once('database/tagEvent.php');
  include_once('database/events.php');
  global $delimiters;

  if(isset($_POST["tagsToSearch"])){
  $searchResults= array();
  $tags=preg_split( "/".$delimiters."+/",$_POST["tagsToSearch"] ); 
  $tagsToSearch=array();
  $searchByTitle=getEventByTitle($_POST["tagsToSearch"]);


    if($searchByTitle) {
      array_push ($searchResults,$searchByTitle);
    }
    else{
     foreach( $tags as $toSearch){
      $tempTag=getTagId($toSearch);
        if($tempTag)
          array_push($tagsToSearch,$tempTag);
      }
      
        $searchResults=getEventsWithAnd($tagsToSearch);
        $searchResultsOR=getEventsWithOr($tagsToSearch);

        if($searchResultsOR){
          if(!empty($searchResults))
          $searchResults= array_unique(array_merge($searchResults,$searchResultsOR), SORT_REGULAR);
        else
          $searchResults=$searchResultsOR;
        } 
    }
 
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
   }
   include_once("templates/footer.php");
?>
 