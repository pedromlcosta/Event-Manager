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

function getEventsWithAnd($tags){
  global $db;
  $queryPart = 'SELECT DISTINCT id FROM events WHERE  visible=1 AND id NOT IN (SELECT events.id as event1 FROM events,tags WHERE tags.id IN (';
  $queryPart2 = ') AND NOT ( tags.id IN    (SELECT tag_id FROM tags_events WHERE event_id=event1 AND visible=1)))';
  $queryPart1 = '';
  for ($i = 0; $i < count($tags); $i++) {
    if ($i == 0) $queryPart1 = $queryPart1 . '?';
    else $queryPart1 = $queryPart1 . ',?';
  }

  $query = $queryPart . $queryPart1 . $queryPart2;
  $stmt = $db->prepare($query);
  $stmt->execute($tags);
  return $stmt->fetchAll();
}

function getEventsWithOr($tags){
  global $db;
  $queryPart = 'SELECT id FROM events WHERE visible=1 AND  id IN (SELECT DISTINCT event_id FROM tags_events WHERE  visible=1 AND tag_id IN (';
  $queryPart1 = '';
  for ($i = 0; $i < count($tags); $i++) {
    if ($i == 0) $queryPart1 = $queryPart1 . '?';
    else $queryPart1 = $queryPart1 . ',?';
  }

  $query = $queryPart . $queryPart1 . '))';
  $stmt = $db->prepare($query);
  $stmt->execute($tags);
  return $stmt->fetchAll();
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
?>
