<?php
function checkIfUserResgisteredInEvent($event,$user){
	global $db;
  $stmt = $db->prepare('SELECT  * FROM eventUsers WHERE event= ? AND attending=?');
  $stmt->execute(array($event,$user));  
  return $stmt->fetch();
}

?>