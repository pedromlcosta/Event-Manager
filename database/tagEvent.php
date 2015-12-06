<?php
function createTagEvent($tagId, $eventId){
  global $db;
  $stmt = $db->prepare('INSERT INTO tags_events (event_id,tag_id,visible) VALUES(? ,?,?)');
  $stmt->execute(array($tagId,$eventId,1));
}

function getEventWithTag($id){
  global $db;
  $stmt = $db->prepare('SELECT  event_id FROM tags_events WHERE  visible=1 AND  tag_id= :id');
  $stmt->bindValue(':id', $id);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getEventsWithAnd($tags,$types,$order,$userID){
  global $db;

$nr_tags=count($tags);
$nr_filters=count($types);

 if($order == 'Date')
    $queryOrder = ' ORDER BY data DESC';
  else if ($order == 'Popularity')
    $queryOrder = ' ORDER BY numberUsers DESC';

$queryPart0 = 'SELECT DISTINCT events.*,users.fullname,types.name as "type" FROM events,events_users,users,types,events_types WHERE events.user_id=users.id AND users.visible=1 AND events_users.visible=1 AND events.visible=1 
AND (events_users.user_id = ? OR events.private = 0)   AND events_types.event_id= events.id AND events_types.type_id=types.id  AND events_users.event_id =events.id 
AND events.id IN   (SELECT DISTINCT event_id FROM events_types WHERE visible=1 AND type_id IN ( ';
  $queryPart1='';
  $queryPart2= ' )  AND event_id NOT IN (SELECT events.id as event1 FROM events,tags WHERE tags.id IN ( ';
  $queryPart3 = '';
  $queryPart4 = ' ) AND NOT ( tags.id IN    (SELECT tag_id FROM tags_events WHERE event_id=event1 AND visible=1))))';
 
 
  if($nr_filters>0)
   createInArray($queryPart1,$nr_filters);
  else
    $queryPart2= ' type_id ';

  if($nr_tags>0)
   createInArray($queryPart3,$nr_tags);
  else
    $queryPart3= ' tag_id ';

  $args=array_merge(array($userID),$types, $tags);
  $query = $queryPart0.$queryPart1.$queryPart2.$queryPart3.$queryPart4.$queryOrder;
 
  $stmt = $db->prepare($query);
  $stmt->execute($args);
  return $stmt->fetchAll();
}

function getEventsWithOr($tags,$types,$order,$userID){
  global $db;

$nr_tags=count($tags);
$nr_filters=count($types);

if($order == 'Date')
    $queryOrder = ' ORDER BY data DESC';
  else if ($order == 'Popularity')
    $queryOrder = ' ORDER BY numberUsers DESC';


//check queries they seem to work
  $queryPart0 = 'SELECT DISTINCT events.*,users.fullname,types.name as "type" FROM events,events_users,users,types,events_types WHERE events.user_id=users.id AND users.visible=1 
   AND events_users.visible=1 AND events.visible=1 AND (events_users.user_id=? OR events.private =0)
   AND events_types.event_id= events.id AND events_types.type_id=types.id
   AND events_users.event_id =events.id AND events.id IN (SELECT DISTINCT event_id FROM events_types WHERE visible=1 and type_id IN ( ';
  $queryPart1= '';//add types IDs
  $queryPart2=' ) AND event_id IN (SELECT DISTINCT event_id FROM tags_events WHERE  visible=1 AND tag_id IN (';
  $queryPart3 = '';//add tags IDs

   if($nr_filters>0)
   createInArray($queryPart1,$nr_filters);
  else
    $queryPart2= ' type_id ';

  if($nr_tags>0)
   createInArray($queryPart3,$nr_tags);
  else
    $queryPart3= ' tag_id ';
 

  $query = $queryPart0.$queryPart1.$queryPart2.$queryPart3.')))'.$queryOrder;

  $args=array_merge(array($userID),$types, $tags);
  $stmt = $db->prepare($query);
  $stmt->execute($args);
  return $stmt->fetchAll();
}
function createInArray(&$array,$times){

  for ($i = 0; $i < $times; $i++) {
    if ($i == 0) $array = $array . '?';
    else $array = $array . ',?';

  }
}

function getTagWithEvent($id){
  global $db;
  $stmt = $db->prepare('SELECT tag_id  FROM tags_events WHERE visible=1 AND event_id= ?');
  $stmt->execute(array($id));
  return $stmt->fetchAll();
}
function updateTagEvents($field,$idField,$id,$changes){
  
  $queryPart1='UPDATE tags_events SET ' ;
  $queryPart2='=? WHERE visible =1 AND ';
  $queryPart3= $idField.'=?';
  $query=$queryPart1.$field.$queryPart2.$queryPart3;
  
  echo "<br>";
  print_r($query);
  global $db;
  $stmt = $db->prepare($query);
  $stmt->execute(array($changes,$id));

}

function removeTagEvents($id){
  
  global $db;
  $stmt = $db->prepare('DELETE FROM   tags_events WHERE tag_id = ?');
  $stmt->execute(array($id));

}
function removeTagEventsByEvent($eventId){
   global $db;
  $stmt = $db->prepare('DELETE FROM   tags_events WHERE event_id = ?');
  $stmt->execute(array($eventId));

}
?>