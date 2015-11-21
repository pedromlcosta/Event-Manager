
<?php
include_once('database/connection.php');
 
function getTag($desc )
{
   global $db;
   $stmt = $db->prepare('SELECT * FROM tag WHERE descprition= :descp');
   $stmt->bindValue(':descp', $desc);
   $stmt->execute();  
   return $stmt->fetch();
}

function insertTag ($descprition)
{
   global $db;
   $stmt = $db->prepare('INSERT INTO tag (descprition) 
               VALUES(:desc)');
   $stmt->bindValue(':desc', $descprition);
   $stmt->execute();  
}
 
function deleteTag($descprition)
{
  global $db;
  $stmt = $db->prepare('DELETE FROM tag WHERE id=:desc') ;
  $stmt->bindParam(':desc', $descprition); 
  $stmt->execute();
}
  ?>