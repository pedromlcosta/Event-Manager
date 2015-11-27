<?php
 
function getImageFromEvent($eventId)
{
   global $db;
  $stmt = $db->prepare('SELECT  image_id FROM events_images WHERE event_id= ?');
  $stmt->execute(array($eventId));  
  return $stmt->fetch();
}
 
  ?>