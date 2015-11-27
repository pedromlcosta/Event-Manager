<?php

function getImage($id)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM images WHERE id= ?');
  $stmt->execute(array($id));  
  return $stmt->fetch();
}
 
  ?>