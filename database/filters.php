<?php

function getFilter($name){
  global $db;
  $stmt = $db->prepare('SELECT  * FROM types WHERE name=? and visible =1');
  $stmt->execute(array($name));

  return $stmt->fetch();

}
function getFilterId($name){
 $temp=getFilter($name);

 if($temp)
 	return $temp['id'];
 else
 	return false;

}

?>