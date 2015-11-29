<?php

function getImage($id){
   global $db;
  $stmt = $db->prepare('SELECT  * FROM images WHERE visible=1 AND id= ?');
  $stmt->execute(array($id));  
  return $stmt->fetch();
}
function getImageByPath($image){
   global $db;
  $stmt = $db->prepare('SELECT  * FROM images WHERE visible=1 AND image= ?');
  $stmt->execute(array($image));  
  return $stmt->fetch();
}
function getLastimageId(){
   global $db;
  $stmt = $db->prepare('SELECT MAX(id) as id  FROM  images WHERE visible=1 ');
  $stmt->execute(array());  
  return $stmt->fetch();

}
function createImage($image){
	 global $db;
   $stmt = $db->prepare('INSERT INTO images( image ,visible) VALUES( ?,? ) ');
   $stmt->execute(array( $image,1));
}
 
  ?>