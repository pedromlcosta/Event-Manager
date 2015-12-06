<?php
//TODO check where I use checkIfUser (Filipe)
function checkIfUserResgisteredInEvent($event,$userAttending){
	global $db;
  $stmt = $db->prepare('SELECT  attending_status FROM events_users WHERE visible=1 AND event_id= ? AND user_id=?');
  $stmt->execute(array($event,$userAttending));  
  return $stmt->fetch();
}

function addUserToEvent($eventId,$userId){
	
	global $db;
	$stmt = $db->prepare('INSERT INTO events_users (user_id,event_id,attending_status) VALUES(?,?,1)');
  	$stmt->execute(array($userId,$eventId));
}

function inviteUserToEvent($eventId,$userId){
	
	global $db;
	$stmt = $db->prepare('INSERT INTO events_users (user_id,event_id,attending_status) VALUES(?,?,0)');
  	$stmt->execute(array($userId,$eventId));
}
function changeAttendingStatus($eventID, $userID, $status){

	global $db;
	$stmt = $db->prepare('UPDATE events_users SET attending_status = ? WHERE event_id = ? AND user_id = ?');
  	$result= $stmt->execute(array($status,$eventID,$userID));


  	print_r($eventID);
  	print_r($userID);
  	print_r($result);
  	return $userID;
}

//TODO: what if event no longer exists?
function removeUserFromEvent($eventId,$userId){
	
	global $db;

	$stmt = $db->prepare('DELETE FROM events_users WHERE events_users.user_id = ? AND events_users.event_id = ?');
  	$stmt->execute(array($userId,$eventId));
}

function removeUserEventByEvent($eventId){
	
	global $db;
	$stmt = $db->prepare('DELETE FROM events_users WHERE   event_id = ?');
  	$stmt->execute(array( $eventId));
}

function isInvited($eventId,$userId){

	$result=checkIfUserResgisteredInEvent($eventId,$userId);
  if($result&&$result['attending_status']==0)
  		return true;
  	else
  		return false;

}
function isAttending($eventId,$userId){

	$result=checkIfUserResgisteredInEvent($eventId,$userId);

	if($result&&$result['attending_status']==1)
  		return true;
  	else
  		return false;

}
?>