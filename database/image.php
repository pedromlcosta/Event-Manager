<?php

function getImage($id){
   global $db;
  $stmt = $db->prepare('SELECT  * FROM images WHERE visible=1 AND id= ?');
  $stmt->execute(array($id));  
  return $stmt->fetch();
}

function getLastimageId(){
   global $db;
  return $db->lastInsertId() ;
}
function createImage($url,$title,$description){
	 global $db;
   $stmt = $db->prepare('INSERT INTO images(url,title,description,visible) VALUES( ?,?,?,? ) ');
   $stmt->execute(array($url,$title,$description,1));
}
  
  ?>