<?php
  include_once('database/image.php');
  include_once('database/imageEvent.php');
  include_once('auxiliar.php');

function getAllEvents(){
  global $db;
  $stmt = $db->prepare('SELECT  * FROM events');
  $stmt->execute(array());

  return $stmt->fetchAll();
}
function deleteEvent($id )
{
   global $db;
  
  $stmt = $db->prepare('DELETE  FROM events WHERE id= ? AND visible=1  ');
  $stmt->execute(array($id));  
}
function getEventIdByField($title,$data,$userID){
    global $db;
  $stmt = $db->prepare('SELECT  id FROM events WHERE title = ? AND data = ? AND user_id = ?');
  $stmt->execute(array($title,$data,$userID));

  return $stmt->fetch()['id'];

}
function getEvent($id,$memberOfEvent)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE id= ? AND visible=1 AND ( private=? OR private=0 )');
  $stmt->execute(array($id,$memberOfEvent));  
  return $stmt->fetch();
}
function isPublic($id){
  $event=getEventInfo($id);
  if($event){
      if($event['private'] == 0)
        return true;
      else
        return false;
  }
  else
    return false;
}
function getEventInfo($eventID){
  global $db;
  $stmt = $db->prepare('SELECT DISTINCT events.*, users.fullname, types.name as \'type\' FROM users, events, events_types, types WHERE events.id = ? AND events.user_id=users.id AND events_types.event_id= events.id AND events_types.type_id=types.id');
  $stmt->execute(array($eventID));
  $res=$stmt->fetch();
  return $res;

}

function getEventByID($id )
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE id= ? AND visible=1');
  $stmt->execute(array($id));  
  return $stmt->fetch();
}
function getEventByDate($date )
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND data=?');
  $stmt->execute(array($date));  
  return $stmt->fetchAll();
  
}
function getEventByDateWithInfo($date ,$userID )
{
   global $db;
  $stmt = $db->prepare('SELECT DISTINCT events.*,users.fullname,types.name as "type" FROM events,events_users,users,types,events_types WHERE
    data=?  AND events_users.visible=1 AND events.visible=1 AND (events_users.user_id=? OR events.private =0) 
  AND events_types.event_id= events.id AND events_types.type_id=types.id  AND events_users.event_id =events.id AND events.id AND users.id=events.user_id');
  $stmt->execute(array($date,$userID));  
  return $stmt->fetchAll();

  
}
function getEventByTitle($title)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND title=?');
  $stmt->execute(array($title));  
  return $stmt->fetchAll();
}

function isOwner($userID,$eventID){
  
  global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND id=? AND user_id= ? ');
  $stmt->execute(array($eventID,$userID));  
  return $stmt->fetch();
}
function getLastEventId(){
  global $db;
  return $db->lastInsertId() ;

}

function getTypes(){
  global $db;

  $stmt = $db->prepare('SELECT DISTINCT types.name FROM types');
  $stmt->execute(array());
  
  $types = null;
  $counter = 0;

  while ($row = $stmt->fetch()) {
    $types[$counter] = $row['name'];
    $counter++;
  }
    
  return $types;

}

function eventsByTitleUserDate($data,$user_id){

  global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE data=? AND user_id=? AND visible=1');
  $stmt->execute(array($data,$user_id));  
  return $stmt->fetchAll();
}
function similarEvents($title,$data,$user_id){

  $eventsUser=eventsByTitleUserDate($data,$user_id);
 
  
  foreach ($eventsUser as $event) {
      global $maxDistance;
      if(levenshtein($event['title'],$title)<=$maxDistance)  {
        return true;
        //Não vai ser sempre assim mas por simplicidiade apenas bloqueamos
      }
  }
  return false;
}
function createEvent($title,$fulltext,$private,$data,$user_id, $imageURL){

 if(!similarEvents($title,$data,$user_id)){
   global $db;
   $stmt = $db->prepare('INSERT INTO events(title,fulltext,private,data,user_id,url,visible) VALUES(?,?,?,?,?,?,?) ');
   $stmt->execute(array($title,$fulltext,$private,$data,$user_id,$imageURL,1));
   return true;  
 }
 else
  return false;
}

function updateEvents($field,$id,$changes){
  
  $queryPart1='UPDATE events SET ' ;
  $queryPart2='=? WHERE visible =1 AND id=?';
  $query=$queryPart1.$field.$queryPart2;
  
  global $db;
  $stmt = $db->prepare($query);
  $stmt->execute(array($changes,$id));

}

// QUERIES FOR MAIN TABS
   
//TODO: Don't show past events -> AND julianblahblah("now") >= event.date
//TODO: Past Attended events tab! 

// Gets events user is connected to - TODO: decide if attends only or attends+invited
function getEventsUserAttending($userID, $order, $events_per_page, $page, $type_filters, $attending_status){
  
  global $db;
  
  if($order == 'Date')
    $queryOrder = ' ORDER BY data DESC';
  else if ($order == 'Popularity')
    $queryOrder = ' ORDER BY numberUsers DESC';
  else if ($order == 'Type')
    $queryOrder = ' ORDER BY type ASC';
  

  $queryLimit =  ' LIMIT ? OFFSET ?';
  
  if($attending_status == 1){
    $querySelect = 'SELECT DISTINCT events.*, users.fullname, types.name as \'type\', events_users.attending_status FROM users, events, events_users, events_types, types WHERE date("now")<=events.data AND events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_users.attending_status=? AND events.user_id=users.id';
    $executeArray = array_merge(array($userID), array($attending_status), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));

    $queryCount = 'SELECT count(DISTINCT events.id) as \'numEvents\' FROM users, events, events_users, events_types, types WHERE date("now")<events.data AND events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_users.attending_status=? AND events.user_id = users.id';
    $executeCountArray = array_merge(array($userID), array($attending_status), $type_filters);
   }else{
    // If we want the invitations: can't get events the owner is hosting - HE CANT INVITE HIMSELF!
    // Therefore: events.user_id != $userID
    $querySelect = 'SELECT DISTINCT events.*, users.fullname, types.name as \'type\', events_users.attending_status FROM users, events, events_users, events_types, types WHERE date("now")<=events.data AND events.user_id != ? AND events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_users.attending_status=? AND events.user_id=users.id';
    $executeArray = array_merge(array($userID, $userID), array($attending_status), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));

    $queryCount = 'SELECT count(DISTINCT events.id) as \'numEvents\' FROM users, events, events_users, events_types, types WHERE date("now")<events.data AND events.user_id != ? AND events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_users.attending_status=? AND events.user_id = users.id';
    $executeCountArray = array_merge(array($userID, $userID), array($attending_status), $type_filters);
   }

   // PREPARING FILTERS

   $nr_filters = count($type_filters);
  
  if($nr_filters > 0){
    $queryTypes = ' AND (';
    for($i = 0; $i < $nr_filters-1; $i++){
      $queryTypes = $queryTypes . " types.name = ? OR ";
    }
    $queryTypes = $queryTypes . 'types.name= ?)';
  }else{
    // NO TYPES SELECTED! THEREFORE NO EVENTS SHOULD SHOW!
    // Returns only the count (which is equal to 0 events)
    $countEvents = array();
    $countEvents[0]['numEvents'] = 0;
   return $countEvents;
  }


  // QUERY PAGE EVENTS

  $query = $querySelect . $queryTypes . $queryOrder . $queryLimit;

  $stmt = $db->prepare($query);
  $stmt->execute($executeArray);
  $events = $stmt->fetchAll();
 
 
  // QUERY TOTAL EVENTS COUNT
  
  $queryCount =   $queryCount . $queryTypes;
  
  $stmt = $db->prepare($queryCount);
  $stmt->execute($executeCountArray);
  $countEvents = $stmt->fetchAll();
  
  
  $result = array_merge($events, $countEvents);
  return $result;
  
}

// Gets events the user is hosting, whether he is going to attend them or not
// If private permission is true: returns hosted public events + private ones the user is permitted to see
// Else: only returns the hosted public events
function getEventsUserHosting($hostID, $userID, $order, $events_per_page, $page, $type_filters, $permissionLevel){
global $db;
  
  if($order == 'Date')
    $queryOrder = ' ORDER BY data DESC';
  else if ($order == 'Popularity')
    $queryOrder = ' ORDER BY numberUsers DESC';
  else if ($order == 'Type')
    $queryOrder = ' ORDER BY type ASC';

  $queryLimit =  ' LIMIT ? OFFSET ?';

  // Permission Level: 0 - Host   1 - Logged user   2 - Logged out
  // Host permission returns all the events the host has made, public + private.
  // Logged user permission returns all the public events + ones he is enrolled in
  // Logged out permission returns all the public events

  if($permissionLevel == 0){

    $querySelect = 'SELECT DISTINCT events.*, users.fullname, types.name as "type", events_users.attending_status FROM users, events, events_users, events_types, types WHERE  date("now")<=events.data AND  events.user_id = ? AND events_users.user_id = users.id AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id=users.id';

    $queryCount = 'SELECT count(DISTINCT events.id) as \'numEvents\' FROM users, events, events_users, events_types, types WHERE date("now")<=events.data AND events.user_id = ? AND events_users.user_id = users.id AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id = users.id';

    $executeArray = array_merge(array($hostID), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));
    $executeCountArray = array_merge(array($hostID), $type_filters);

  }else if ($permissionLevel == 1){
    //falta este

     $querySelect = 'SELECT DISTINCT events.*, users.fullname, types.name as "type" FROM users, events, events_users, events_types, types WHERE date("now")<=events.data AND events.user_id = ? AND (events.private=0 OR (events_users.user_id = ? AND events_users.event_id = events.id)) AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id=users.id';

    $queryCount = 'SELECT count(DISTINCT events.id) as \'numEvents\' FROM users, events, events_users, events_types, types WHERE date("now")<=events.data AND events.user_id = ? AND (events.private=0 OR (events_users.user_id = ? AND events_users.event_id = events.id)) AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id=users.id';

    $executeArray = array_merge(array($hostID, $userID), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));
    $executeCountArray = array_merge(array($hostID, $userID), $type_filters);
  }else if ($permissionLevel == 2){

    $querySelect = 'SELECT DISTINCT events.*, users.fullname, types.name as "type" FROM users, events, events_types, types WHERE date("now")<=events.data AND events.private = 0 AND events.user_id = ? AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id=users.id';

    $queryCount = 'SELECT count(DISTINCT events.id) as \'numEvents\' FROM users, events, events_users, events_types, types WHERE date("now")<=events.data AND events.private = 0 AND events.user_id = ? AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id = users.id';

    $executeArray = array_merge(array($hostID), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));
    $executeCountArray = array_merge(array($hostID), $type_filters);
  }

  // Preparing filters
   $nr_filters = count($type_filters);
  
  if($nr_filters > 0){
    $queryTypes = ' AND (';
    for($i = 0; $i < $nr_filters-1; $i++){
      $queryTypes = $queryTypes . " types.name = ? OR ";
    }
    $queryTypes = $queryTypes . 'types.name= ?)';
  }else{

    $countEvents = array();
    $countEvents[0]['numEvents'] = 0;
   return $countEvents;
  }

  // Doing page events query
  $query = $querySelect . $queryTypes . $queryOrder . $queryLimit;
  
  $stmt = $db->prepare($query);
  $stmt->execute($executeArray);
  $events = $stmt->fetchAll();


  // Doing total events count query
  $queryCount =   $queryCount . $queryTypes;
  
  $stmt = $db->prepare($queryCount);
  $stmt->execute($executeCountArray);
  $countEvents = $stmt->fetchAll();
  
  $result = array_merge($events, $countEvents);
  
  return $result;
  
}

function getAllVisibleEvents($userID, $order, $events_per_page, $page, $type_filters){
  
  global $db;
  
  if($order == 'Date')
    $queryOrder = ' ORDER BY data DESC';
  else if ($order == 'Popularity')
    $queryOrder = ' ORDER BY numberUsers DESC';
  else if ($order == 'Type')
    $queryOrder = ' ORDER BY type ASC';

  $queryLimit =  ' LIMIT ? OFFSET ?';

  $querySelect = 'SELECT DISTINCT events.*, users.fullname, types.name as "type" FROM users, events, events_users, events_types, types WHERE (events.private=0 OR (events_users.user_id = ? AND events_users.event_id = events.id)) AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id=users.id';
   $nr_filters = count($type_filters);
  
  if($nr_filters > 0){
    $queryTypes = ' AND (';
    for($i = 0; $i < $nr_filters-1; $i++){
      $queryTypes = $queryTypes . " types.name = ? OR ";
    }
    $queryTypes = $queryTypes . 'types.name= ?)';
  }else{

    $countEvents = array();
    $countEvents[0]['numEvents'] = 0;
   return $countEvents;
  }
  $query = $querySelect . $queryTypes . $queryOrder . $queryLimit;
  $executeArray = array_merge(array($userID), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));
  
  $stmt = $db->prepare($query);
  $stmt->execute($executeArray);
  $events = $stmt->fetchAll();
 
 
  // COUNT EVENTS RESULTING FROM QUERY
  $queryCount = 'SELECT count(DISTINCT events.id) as "numEvents" ';
  $queryCount.= 'FROM users, events, events_users, events_types, types ';
  $queryCount.= 'WHERE (events.private=0 OR (events_users.user_id = ? AND events_users.event_id = events.id)) AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id = users.id';
  $query2 =   $queryCount . $queryTypes;
  
  $stmt = $db->prepare($query2);
  $stmt->execute(array_merge(array($userID), $type_filters));
  $countEvents = $stmt->fetchAll();
  
  $result = array_merge($events, $countEvents);
  
  return $result;
  
}

function compareEvents($event, $event1){
 
  if($event['id'] === $event1['id'])
    return 0;
  else
    if($event['id'] > $event1['id'])
      return 1;

    return -1;
}
 
function customSearch($userID,$userProvidedTags,$dateTag,$typeFilters,$order, $events_per_page, $page){
    global $delimiters;

    if(!isset($userID))
      $userID=null;

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
  if(strlen($userProvidedTags)>0){
        $tags = preg_split("/" . $delimiters . "+/",$userProvidedTags);
        $tagsToSearch = array();
        //TODO
        $registeredInEvent = 0;

          foreach($tags as $toSearch) {
            $tempTag = getTagId($toSearch);
            if ($tempTag) array_push($tagsToSearch, $tempTag);
          }
          if(!empty($tagsToSearch)){
                    $searchResults = getEventsWithAnd($tagsToSearch,$filtersIDs,$order,$userID);
                    $searchResultsOR = getEventsWithOr($tagsToSearch,$filtersIDs,$order,$userID);
                 
                    if ($searchResultsOR) {
                      if (!empty($searchResults)) $searchResults = array_unique(array_merge($searchResults, $searchResultsOR) , SORT_REGULAR);
                      else $searchResults = $searchResultsOR;
           }         }
  }
  else
    $noEvents=true;

if (strlen($dateTag)>0) {
        $eventsWithDate = getEventByDateWithInfo($dateTag,$userID);
        if ($eventsWithDate){ 
        if (!empty($searchResults))
          $searchResults = array_uintersect($searchResults, $eventsWithDate, 'compareEvents');
        else
          $searchResults = $eventsWithDate;
      }
        else 
          $searchResults=array();
      }
      else
        $noData=true;

      
      if($noData && $noEvents){

        return  getAllVisibleEvents($userID, $order, $events_per_page, $page, $typeFilters);
      }

      $nResults=count($searchResults);
      $searchResults=array_slice($searchResults,$events_per_page*($page-1),$events_per_page);
      $countEvents = array();
      $countEvents[0]['numEvents'] = $nResults;
      $searchResults = array_merge($searchResults, $countEvents);
      return $searchResults;
}


function updateEventImage($eventID, $imageURL){
  global $db;

  $query = 'UPDATE events SET url = ? WHERE id = ?';
  $stmt = $db->prepare($query);
  $result = $stmt->execute(array($imageURL, $eventID));

  return $result;
}

function deleteEventImage($rowID){
  global $db;

  $query = 'SELECT * FROM events WHERE id = ?';
  $stmt = $db->prepare($query);
  $stmt->execute(array($rowID));

  $result = $stmt->fetch();
  $url = $result['url'];

  if($url != 'images/backg.jpg')
    unlink($url);
}
?>