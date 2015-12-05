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

  return $stmt->All();
}
function getFilterId($name){
 $temp=getFilter($name);

 if($temp)
 	return $temp['id'];
 else
 	return false;

}

function addEventsTypes($eventID,$typeID){
	print_r($typeID);
  global $db;
  $stmt = $db->prepare('INSERT INTO events_types (event_id,type_id) VALUES(?,?)');
  $res= $stmt->execute(array($eventID,$typeID));
 if($res)
 	return true;
 else 
 	return false;
}

function updateEventsTypes($eventID,$typeID,$newEventID,$newTypeID){
  global $db;
  $stmt = $db->prepare('UPDATE  events_types SET event_id = ?, type_id = ? WHERE event_id = ? AND type_id = ?');
   $res= $stmt->execute(array($newEventID,$newTypeID,$eventID,$typeID));
  if($res)
 	return true;
 else 
 	return false;
}



?>