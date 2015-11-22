<?php
 
function getImageFromEvent($eventId)
{
   global $db;
  $stmt = $db->prepare('SELECT  image FROM imageEvent WHERE event= ?');
  $stmt->execute(array($eventId));  
  return $stmt->fetch();
}
 
  ?>