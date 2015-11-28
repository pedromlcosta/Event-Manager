<?php

function getImage($id){
   global $db;
  $stmt = $db->prepare('SELECT  * FROM images WHERE id= ?');
  $stmt->execute(array($id));  
  return $stmt->fetch();
}
function getImageByPath($image){
   global $db;
  $stmt = $db->prepare('SELECT  * FROM images WHERE image= ?');
  $stmt->execute(array($image));  
  return $stmt->fetch();
}
function getLastimageId(){
   global $db;
  $stmt = $db->prepare('SELECT MAX(id) as id  FROM images');
  $stmt->execute(array());  
  return $stmt->fetch();

}
function createImage($image){
	 global $db;
   $stmt = $db->prepare('INSERT INTO images( image ,visible) VALUES( ?,? ) ');
   $stmt->execute(array( $image,1));
}
 
  ?>