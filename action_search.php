 <?php

include_once('init.php');
include_once('auxiliar.php');
include_once("database/users.php");
include_once('templates/header.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/events.php');
include_once('database/usersEvent.php');
include_once('database/filters.php');
 
//TODO check the permission stuff,provavelmente vou ter de adecionar à query no big deal,just one more select etc...
//TODO THE SPLICE E DIVIDIR POR PÀGINA E COUNT E ISSO
// add to get event Owner e pic url 
function customSearch($userID,$userProvidedTags,$dateTag,$typeFilters,$order, $events_per_page, $page){
    global $delimiters;


     if(count($typeFilters) == 0){
       $countEvents = array();
        $countEvents[0]['numEvents'] = 0;
       return $countEvents;
     }
     else {
      $filtersIDs=array();

      foreach ($typeFilters as $filter  ) {
        $tempFilter=getFilterId($filter);
        if($tempFilter)
          array_push($filtersIDs,$tempFilter);
      }

     }

    $noEvents=false;
    $noData=false;

    $searchResults = array();
  if(count($userProvidedTags)>0){
        $tags = preg_split("/" . $delimiters . "+/",$userProvidedTags);
        $tagsToSearch = array();
        //TODO
        $registeredInEvent = 0;

          foreach($tags as $toSearch) {
            $tempTag = getTagId($toSearch);
            if ($tempTag) array_push($tagsToSearch, $tempTag);
          }
          $searchResults = getEventsWithAnd($tagsToSearch,$filtersIDs,$order,$events_per_page,$page);
          $searchResultsOR = getEventsWithOr($tagsToSearch,$filtersIDs,$order,$events_per_page,$page);

          echo "<br>";
          print_r($searchResults);
          echo "<br>";
          print_r($searchResultsOR);
          echo "<br>";
       
          if ($searchResultsOR) {
            if (!empty($searchResults)) $searchResults = array_unique(array_merge($searchResults, $searchResultsOR) , SORT_REGULAR);
            else $searchResults = $searchResultsOR;
          }
           echo "<br>";
          print_r($searchResults);
          echo "<br>";
  }
  else
    $noEvents=true;

      if (!isset($dateTag)) {
        $eventsWithDate = getEventByDate($dateTag);

        if ($eventsWithDate){ 
        if (!empty($searchResults))
          $searchResults = array_uintersect($searchResults, $eventsWithDate, 'compareEvents');
        else
          $searchResults = $eventsWithDate;
      }
        else array_splice($searchResults, 0);
      }
      else
        $noData=true;

      if($noData && $noEvents){
        return  getAllVisibleEvents($userID, $order, $events_per_page, $page, $typeFilters);
      }
      $nResults=count($searchResults);
      $searchResults=array_slice($searchResults,$events_per_page*($page-1),$events_per_page);
      $afterSliceSize=count($searchResults);
      $searchResults[ $afterSliceSize]['numEvents']=$nResults;
      echo "<br>";
      echo print_r($searchResults);
 
      return $searchResults;
  }
?>
 