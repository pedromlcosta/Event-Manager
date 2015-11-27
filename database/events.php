<?php
  include_once('database/image.php');
  include_once('database/imageEvent.php');
$imageExtension =array('jpg','png','jpeg','gif');
$maxDistance=2;

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
  $stmt = $db->prepare('SELECT  * FROM events WHERE user_id= ? ');
  $stmt->execute(array($username));  
  return $stmt->fetch();
}
function getLastEventId(){
  global $db;
  $stmt = $db->prepare('SELECT MAX(id) as id FROM events');
  $stmt->execute();  
  return $stmt->fetch();

}

function eventsByTitleUserDate($data,$user_id){

    global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE data=? AND user_id=? AND visible=1');
  $stmt->execute(array($data,$user_id));  
  return $stmt->fetchAll();
}
function similarEvents($title,$data,$user_id){

  $eventsUser=eventsByTitleUserDate($data,$user_id);
  print_r($eventsUser);
  echo "<br>";
  print_r($title);
  echo "<br>";
  
  foreach ($eventsUser as $event) {
  print_r($event);
  echo "<br>";
  print_r(levenshtein($event['title'],$title));
      global $maxDistance;
      if(levenshtein($event['title'],$title)<=$maxDistance)  {
        return true;

        //Não vai ser sempre assim mas por simplicidiade apenas bloqueamos
      }
  }
  return false;
}
function createEvent($title,$fulltext,$private,$data,$user_id){

//Acrescentar verificações de semelhança com outros eventos do user como nome data e isso 
//parse do texto, how to prevent scripts?
//test if image is a valid must end in either .jpg .png .jpeg
//same for tags, need to also do it in the search

 if(!similarEvents($title,$data,$user_id)){
   global $db;
   $stmt = $db->prepare('INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES(?,?,?,?,?,?) ');
   $stmt->execute(array($title,$fulltext,$private,$data,$user_id,1));
   return true;  
 }
 else
  return false;
}
function validateInput($input){
      if ( !preg_match ("/^[a-zA-Z\s]+$/", $input)) {
      // ERROR: Name can only contain letters and spaces
        return true;
    }
    return false;
}
?>
