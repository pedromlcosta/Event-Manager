<?php
  include_once('database/image.php');
  include_once('database/imageEvent.php');
  include_once('auxiliar.php');

function getAllEvents(){
  global $db;
  $stmt = $db->prepare('SELECT  * FROM events');
  $stmt->execute(array());

  return $stmt->fetchAll();
}

function getEvent($id,$memberOfEvent)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE id= ? AND visible=1 AND ( private=? OR private=0 )');
  $stmt->execute(array($id,$memberOfEvent));  
  return $stmt->fetch();
}
function getEventByID($id )
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE id= ? AND visible=1');
  $stmt->execute(array($id));  
  return $stmt->fetch();
}
function getEventByDate($date)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND data=?');
  $stmt->execute(array($date));  
  return $stmt->fetchAll();
}
function getEventByTitle($title)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND title=?');
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
  $stmt = $db->prepare('SELECT  * FROM events WHERE visible=1 AND user_id= ? ');
  $stmt->execute(array($username));  
  return $stmt->fetch();
}
function getLastEventId(){
  global $db;
  $stmt = $db->prepare('SELECT MAX(id) as id FROM  events WHERE visible=1');
  $stmt->execute();  
  return $stmt->fetch();

}

function getTypes(){
  global $db;

  $stmt = $db->prepare('SELECT DISTINCT types.name FROM types');
  $stmt->execute(array());
  
  $types = null;
  $counter = 0;

  while ($row = $stmt->fetch()) {
    $types[$counter] = $row['name'];
    $counter++;
  }
    
  return $types;

}

function eventsByTitleUserDate($data,$user_id){

  global $db;
  $stmt = $db->prepare('SELECT  * FROM events WHERE data=? AND user_id=? AND visible=1');
  $stmt->execute(array($data,$user_id));  
  return $stmt->fetchAll();
}
function similarEvents($title,$data,$user_id){

  $eventsUser=eventsByTitleUserDate($data,$user_id);
 
  
  foreach ($eventsUser as $event) {
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

function updateEvents($field,$id,$changes){
  
  $queryPart1='UPDATE events SET ' ;
  $queryPart2='=? WHERE visible =1 AND id=?';
  $query=$queryPart1.$field.$queryPart2;
  
  global $db;
  $stmt = $db->prepare($query);
  $stmt->execute(array($changes,$id));

}

// QUERIES FOR MAIN TABS
    //TODO: Adicionar filtros e ordenacao
//Order is either 'date' or 'popularity'
function getEventsUserAttending($userID, $order){
  global $db;

  if($order == 'date')
    $queryOrder = 'ORDER BY data DESC';
  else if ($order == 'popularity')
    $queryOrder = 'ORDER BY count()';

  $stmt = $db->prepare($query);
  $stmt->execute(array($changes,$id));
}


?>
