<?php
 
function getImageFromEvent($eventId)
{
   global $db;
  $stmt = $db->prepare('SELECT  image_id FROM events_images WHERE visible=1 AND event_id= ?');
  $stmt->execute(array($eventId));  
  return $stmt->fetch();
}
function createImageEvent($eventId,$imageId){
	 global $db;
   $stmt = $db->prepare('INSERT INTO events_images(event_id,image_id,visible) VALUES(?,?,? ) ');
   $stmt->execute(array($eventId,$imageId,1));
}
 
  ?>