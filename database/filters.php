<?php

function getFilter($name){
  global $db;
  $stmt = $db->prepare('SELECT  * FROM types WHERE name=? AND visible =1');
  $stmt->execute(array($name));

  return $stmt->fetch();

}
function getAllFilters(){
	  global $db;
  $stmt = $db->prepare('SELECT name,id FROM types WHERE  visible =1');
  $stmt->execute(array($name));

  return $stmt->All();
}
function getFilterId($name){
 $temp=getFilter($name);

 if($temp)
 	return $temp['id'];
 else
 	return false;

}

?>