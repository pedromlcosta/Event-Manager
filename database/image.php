<?php

function getImage($id)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM image WHERE id= ?');
  $stmt->execute(array($id));  
  return $stmt->fetch();
}
 
  ?>