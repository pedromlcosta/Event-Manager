
<?php
 
function getTag($desc)
{
   global $db;
  $stmt = $db->prepare('SELECT  * FROM tag WHERE description= ?');
  $stmt->execute(array($desc));  
  return $stmt->fetch();
}
function insertTag ($description)
{
   global $db;
   $stmt = $db->prepare('INSERT INTO tag (description) 
               VALUES(:desc)');
   $stmt->bindValue(':desc', $description);
   $stmt->execute();  
}
 
function deleteTag($description)
{
  global $db;
  $stmt = $db->prepare('DELETE FROM tag WHERE id=:desc') ;
  $stmt->bindParam(':desc', $description); 
  $stmt->execute();
}
  ?>