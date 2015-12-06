<?php

function getFilter($name){
  global $db;
  $stmt = $db->prepare('SELECT  * FROM types WHERE name=? AND visible =1');
  $stmt->execute(array($name));

  return $stmt->fetch();

}
function getAllFilters(){
	  global $db;
  $stmt = $db->prepare('SELECT name,id FROM types WHERE  visible =1');
  $stmt->execute(array($name));

  return $stmt->fetchAll();
}
function getFilterId($name){
 $temp=getFilter($name);

 if($temp)
 	return $temp['id'];
 else
 	return false;

}
function getTypeByEvent($eventID){
    global $db;
  $stmt = $db->prepare('SELECT *  FROM types WHERE id IN(SELECT type_id FROM events_types WHERE event_id = ? AND visible =1)');
  $stmt->execute(array($eventID));

  return $stmt->fetch();

}
function addEventsTypes($eventID,$typeID){
  global $db;
  $stmt = $db->prepare('INSERT INTO events_types (event_id,type_id) VALUES(?,?)');
  $res= $stmt->execute(array($eventID,$typeID));
 if($res)
 	return true;
 else 
 	return false;
}

function updateEventsTypes($eventID,$newTypeID){
  global $db;
  $stmt = $db->prepare('UPDATE  events_types SET  type_id = ? WHERE event_id = ? ');
   $res= $stmt->execute(array($newTypeID,$eventID));
  if($res)
 	return true;
 else 
 	return false;
}



?>