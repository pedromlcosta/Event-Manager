<?php
//TODO check where I use checkIfUser (Filipe)
function checkIfUserResgisteredInEvent($event,$userAttending){
	global $db;
  $stmt = $db->prepare('SELECT  attending FROM events_users WHERE visible=1 AND event_id= ? AND user_id=?');
  $stmt->execute(array($event,$userAttending));  
  return $stmt->fetch();
}
function addUserToEvent($eventId,$userId){
	
	global $db;
	$stmt = $db->prepare('INSERT INTO events_users (user_id,event_id,attending_status) VALUES(?,?,?)');
  	$stmt->execute(array($userId,$eventId,1,1));
}
function inviteUserToEvent($eventId,$userId){
	
	global $db;
	$stmt = $db->prepare('INSERT INTO events_users (user_id,event_id,attending_status) VALUES(?,?,?)');
  	$stmt->execute(array($userId,$eventId,1,0));
}
function removeUserFromEvent($eventId,$userId){
	
	global $db;
	$stmt = $db->prepare('DELETE FROM events_users WHERE events_users.user_id = ? AND events_users.event_id = ?');
  	$stmt->execute(array($userId,$eventId));
}
?>
