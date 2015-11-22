<?php
  
function getEventWithTag($id)
{
   global $db;
   $stmt = $db->prepare('SELECT  event FROM tagEvent WHERE tag= :id');
   $stmt->bindValue(':id', $id);
   $stmt->execute();  
   return $stmt->fetchAll();
} 

function getTagWithEvent($id)
{
   global $db;
   $stmt = $db->prepare('SELECT * FROM tagEvent WHERE event= :id');
   $stmt->bindValue(':id', $id);
   $stmt->execute();  
   return $stmt->fetchAll();
}
 
  ?>