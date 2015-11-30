 <?php
include_once('genericStart.html'); 
include_once('init.php');
include_once("database/users.php");
include_once('templates/header.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/events.php');
include_once('database/usersEvent.php');
global $delimiters;
  if(isset($_POST["tagsToSearch"]) && !(empty($_POST["tagsToSearch"])&& empty($_POST['dateTag']))  ){


    $searchResults = array();
    $tags = preg_split("/" . $delimiters . "+/", $_POST["tagsToSearch"]);
    $tagsToSearch = array();
    $searchByTitle = getEventByTitle($_POST["tagsToSearch"]);
    $registeredInEvent['attending'] = 0;

    if ($searchByTitle) {
      array_push($searchResults, $searchByTitle);
    }
    else {
      foreach($tags as $toSearch) {
        $tempTag = getTagId($toSearch);
        if ($tempTag) array_push($tagsToSearch, $tempTag);
      }

      $searchResults = getEventsWithAnd($tagsToSearch);
      $searchResultsOR = getEventsWithOr($tagsToSearch);
      if ($searchResultsOR) {
        if (!empty($searchResults)) $searchResults = array_unique(array_merge($searchResults, $searchResultsOR) , SORT_REGULAR);
        else $searchResults = $searchResultsOR;
      }
    }

    if (!empty($searchResults)) {
      if (!empty($_POST['dateTag'])) {
        $eventsWithDate = getEventByDate($_POST['dateTag']);
        if ($eventsWithDate) $searchResults = array_uintersect($searchResults, $eventsWithDate, 'compareEvents');
        else array_splice($searchResults, 0);
      }

      if (empty($searchResults)) {
        echo "No events match you search";
      }
      else {
        foreach($searchResults as $event) {

          // change it does matter if he is logged in but not in the way I did it

          if (isLogged()) {

            // might change accordingly if we add an id to user
            $registeredInEvent = checkIfUserResgisteredInEvent($event['id'],$_SESSION['userID']);
              if(!$registeredInEvent)
                $registeredInEvent['attending'] = 0;
          }

          $toPrintEvent = getEvent($event['id'], $registeredInEvent['attending']);
          if ($toPrintEvent) {
            $eventImage = eventGetImage($event['id']);
            include_once ("templates/list_search_results.php");

          }
          // add button to go back or go back to main page falta ainda ver quando tem sessão iniciada
        }
      }
    }
       include_once("templates/footer.php");
}
?>
 