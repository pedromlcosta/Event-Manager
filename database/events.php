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
function getEventByDate($date)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE data=?');
  $stmt->execute(array($date));  
  return $stmt->fetchAll();
}
function getEventByTitle($title)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE title=?');
  $stmt->execute(array($title));  
  return $stmt->fetchAll();
}
 function eventGetImage($id)
{
   global $db;
  $image=getImageFromEvent($id);
  $value= getImage($image['image']);
  return $value;
}
function isOwner($username){
  
  global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE user= ? ');
  $stmt->execute(array($username));  
  return $stmt->fetch();
}

function createEvent($args){

  //parse do texto, how to prevent scripts?
 //test if image is a valid must end in either .jpg .png .jpeg
//same for tags, need to also do it in the search
  print_r($args);
}
?>
