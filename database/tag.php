<?php

function createTag($args){
  global $db;
  $stmt = $db->prepare('INSERT INTO tags (description) VALUES(?)');
  $stmt->execute(array( $args));
  return getTagId($args);
}

function getTag($desc)
{
  global $db;
  $stmt = $db->prepare('SELECT  * FROM tags WHERE visible=1 AND description= ?');
  $stmt->execute(array( $desc));
  return $stmt->fetch();
}

function getTagById($id)
{
  global $db;
  $stmt = $db->prepare('SELECT  * FROM tags WHERE visible=1 AND id= ?');
  $stmt->execute(array($id));
  return $stmt->fetch();
}

function getTagDesc($id)
{
  $tag = getTagById($id);
  if ($tag) return $tag['description'];
  else return false;
}

function getTagId($desc)
{
  $tempTag = getTag($desc);
  if ($tempTag) return $tempTag['id'];
  else return false;
}

function getLastTagId(){

  global $db;
  $stmt = $db->prepare('SELECT MAX(id) as id FROM  tags WHERE visible=1');
  $stmt->execute();  
  return $stmt->fetch();
}
function updateTags($field,$id,$changes){
  
  $queryPart1='UPDATE tags SET ' ;
  $queryPart2='=? WHERE visible =1 AND id=?';
  $query=$queryPart1.$field.$queryPart2;
  
  echo "<br>";
  print_r($query);
  global $db;
  $stmt = $db->prepare($query);
  $stmt->execute(array($changes,$id));

}
?>