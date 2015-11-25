<?php
 
function getTag($desc)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM tag WHERE description= ?');
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
   $stmt = $db->prepare('INSERT INTO tag (description) 
               VALUES(:desc)');
   $stmt->bindValue(':desc', $description);
   $stmt->execute();  
}
 
function deleteTag($id)
{
  global $db;
  $stmt = $db->prepare('DELETE FROM tag WHERE id=:id') ;
  $stmt->bindParam(':id', $id); 
  $stmt->execute();
}
  ?>