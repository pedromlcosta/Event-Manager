<?php
  function createTag($args){
    global $db;
    $stmt = $db->prepare('INSERT INTO tags (description) VALUES(?)');
    $stmt->execute(array($args)); 
    return getTagId($args);
  }

function getTag($desc)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM tags WHERE description= ?');
  $stmt->execute(array($desc));  
  return $stmt->fetch();
}
function getTagId($desc){

  $tempTag=getTag($desc);
  if($tempTag)
    return $tempTag['id'];
  else
    return false;
}
function insertTag ($description)
{
   global $db;
   $stmt = $db->prepare('INSERT INTO tags (description) 
               VALUES(:desc)');
   $stmt->bindValue(':desc', $description);
   $stmt->execute();  
}
 
function deleteTag($id)
{
  global $db;
  $stmt = $db->prepare('DELETE FROM tags WHERE id=:id') ;
  $stmt->bindParam(':id', $id); 
  $stmt->execute();
}
  ?>