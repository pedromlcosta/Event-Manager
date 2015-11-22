<?php
  include_once('database/image.php');
  include_once('database/imageEvent.php');

function getEvent($id,$loggedIn)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE id= ? AND private=?');
  $stmt->execute(array($id,$loggedIn));  
  return $stmt->fetch();
}
 function eventGetImage($id)
{
   global $db;
  $image=getImageFromEvent($id);
  $value= getImage($image['image']);
  return $value;
}
  ?>