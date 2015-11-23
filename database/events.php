<?php
  include_once('database/image.php');
  include_once('database/imageEvent.php');

function getEvent($id,$memberOfEvent)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE id= ? AND ( private=? OR private=0 )');
  $stmt->execute(array($id,$memberOfEvent));  
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