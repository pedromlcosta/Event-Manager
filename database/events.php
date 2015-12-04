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

function getEvent($id,$memberOfEvent)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE id= ? AND visible=1 AND ( private=? OR private=0 )');
  $stmt->execute(array($id,$memberOfEvent));  
  return $stmt->fetch();
}

function getEventInfo($eventID){
  global $db;

  $stmt = $db->prepare('SELECT DISTINCT events.*, images.url, users.fullname, types.name as \'type\' FROM users, events, events_types, types, images, events_images WHERE events.id = ? AND events.user_id=users.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_images.event_id=events.id AND events_images.image_id=images.id');
  $stmt->execute(array($eventID));

  return $stmt->fetch();

}

function getEventByID($id )
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE id= ? AND visible=1');
  $stmt->execute(array($id));  
  return $stmt->fetch();
}
function getEventByDate($date)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND data=?');
  $stmt->execute(array($date));  
  return $stmt->fetchAll();
}
function getEventByTitle($title)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND title=?');
  $stmt->execute(array($title));  
  return $stmt->fetchAll();
}
 function eventGetImage($id)
{
   global $db;
  $image=getImageFromEvent($id);
  $value= getImage($image['image']);
  return $value;
}
function isOwner($username){
  
  global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND user_id= ? ');
  $stmt->execute(array($username));  
  return $stmt->fetch();
}
function getLastEventId(){
  global $db;
  $stmt = $db->prepare('SELECT MAX(id) as id FROM  events WHERE visible=1');
  $stmt->execute();  
  return $stmt->fetch();

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
function createEvent($title,$fulltext,$private,$data,$user_id){

//Acrescentar verificações de semelhança com outros eventos do user como nome data e isso 
//parse do texto, how to prevent scripts?
//test if image is a valid must end in either .jpg .png .jpeg
//same for tags, need to also do it in the search

 if(!similarEvents($title,$data,$user_id)){
   global $db;
   $stmt = $db->prepare('INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES(?,?,?,?,?,?) ');
   $stmt->execute(array($title,$fulltext,$private,$data,$user_id,1));
   return true;  
 }
 else
  return false;
}
function validateInput($input){
      if ( !preg_match ("/^[a-zA-Z\s]+$/", $input)) {
      // ERROR: Name can only contain letters and spaces
        return true;
    }
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
   
// Gets events user is connected to - TODO: decide if attends only or attends+invited
function getEventsUserAttending($userID, $order, $events_per_page, $page, $type_filters, $attending_status){
  
  global $db;
  
  if($order == 'Date')
    $queryOrder = ' ORDER BY data DESC';
  else if ($order == 'Popularity')
    $queryOrder = ' ORDER BY numberUsers DESC';
  $queryLimit =  ' LIMIT ? OFFSET ?';
  
  if($attending_status == 1){
    $querySelect = 'SELECT DISTINCT events.*, images.url, users.fullname, types.name as \'type\', events_users.attending_status FROM users, events, events_users, events_types, types, images, events_images WHERE events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_images.event_id=events.id AND events_images.image_id=images.id AND events_users.attending_status=? AND events.user_id=users.id';
    $executeArray = array_merge(array($userID), array($attending_status), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));

    $queryCount = 'SELECT count(DISTINCT events.id) as \'numEvents\' FROM users, events, events_users, events_types, types WHERE events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_users.attending_status=? AND events.user_id = users.id';
    $executeCountArray = array_merge(array($userID), array($attending_status), $type_filters);
   }else{
    // If we want the invitations: can't get events the owner is hosting - HE CANT INVITE HIMSELF!
    // Therefore: events.user_id != $userID
    $querySelect = 'SELECT DISTINCT events.*, images.url, users.fullname, types.name as \'type\', events_users.attending_status FROM users, events, events_users, events_types, types, images, events_images WHERE events.user_id != ? AND events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_images.event_id=events.id AND events_images.image_id=images.id AND events_users.attending_status=? AND events.user_id=users.id';
    $executeArray = array_merge(array($userID, $userID), array($attending_status), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));

    $queryCount = 'SELECT count(DISTINCT events.id) as \'numEvents\' FROM users, events, events_users, events_types, types WHERE events.user_id != ? AND events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_users.attending_status=? AND events.user_id = users.id';
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
function getEventsUserHosting($userID, $order, $events_per_page, $page, $type_filters){
global $db;
  
  if($order == 'Date')
    $queryOrder = ' ORDER BY data DESC';
  else if ($order == 'Popularity')
    $queryOrder = ' ORDER BY numberUsers DESC';
  $queryLimit =  ' LIMIT ? OFFSET ?';

  $querySelect = 'SELECT DISTINCT events.*, images.url, users.fullname, types.name as \'type\', events_users.attending_status FROM users, events, events_users, events_types, types, images, events_images WHERE events.user_id = ? AND events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_images.event_id=events.id AND events_images.image_id=images.id AND events.user_id=users.id';
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
  $executeArray = array_merge(array($userID, $userID), $type_filters, array($events_per_page,  ($page-1) * $events_per_page));
  
  $stmt = $db->prepare($query);
  $stmt->execute($executeArray);
  $events = $stmt->fetchAll();
 
 
  // COUNT EVENTS RESULTING FROM QUERY
  $queryCount = 'SELECT count(DISTINCT events.id) as \'numEvents\' FROM users, events, events_users, events_types, types WHERE events.user_id = ? AND events_users.user_id = ? AND events_users.event_id = events.id AND events_types.event_id= events.id AND events_types.type_id=types.id AND events.user_id = users.id';
  $query2 =   $queryCount . $queryTypes;
  
  $stmt = $db->prepare($query2);
  $stmt->execute(array_merge(array($userID, $userID), $type_filters));
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
  $queryLimit =  ' LIMIT ? OFFSET ?';

  $querySelect = 'SELECT DISTINCT events.*, images.url, users.fullname, types.name as "type" FROM users, events, events_users, events_types, types, images, events_images WHERE (events.private=0 OR (events_users.user_id = ? AND events_users.event_id = events.id)) AND events_types.event_id= events.id AND events_types.type_id=types.id AND events_images.event_id=events.id AND events_images.image_id=images.id AND events.user_id=users.id';
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

function compareEvents($tagEvent, $tagEvent1)
{
  return ($tagEvent['id'] == $tagEvent1['id']);
}
 

?>


