<?php
function checkIfUserResgisteredInEvent($event,$userAttending){
	global $db;
  $stmt = $db->prepare('SELECT  * FROM events_users WHERE visible=1 AND event= ? AND attending=?');
  $stmt->execute(array($event,$userAttending));  
  return $stmt->fetch();
}
function addUserToEvent($eventId,$userId){
	
	global $db;
	$stmt = $db->prepare('INSERT INTO events_users (user_id,event_id,visible) VALUES(? ,?,?)');
  	$stmt->execute(array($userId,$eventId,1));
}

?>
