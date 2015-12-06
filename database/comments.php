<?php

function getEventComments($eventID, $comments_per_page, $page){
  
  global $db;
  
  $queryOrder = ' ORDER BY data DESC';
 
  $queryLimit =  ' LIMIT ? OFFSET ?';
   
   
 // QUERY EVENT COMMENTS

  $querySelect = 'SELECT DISTINCT comments.*, users.imageURL, users.fullname FROM comments, users, events WHERE users.id = comments.user_id AND comments.event_id = ?';
  $executeArray = array($eventID, $comments_per_page,  ($page-1) * $comments_per_page);

 
  $query = $querySelect . $queryOrder . $queryLimit;
 
  $stmt = $db->prepare($query);
  $stmt->execute($executeArray);
  $comments = $stmt->fetchAll();
 
 
  // QUERY TOTAL EVENT COMMENTS COUNT
    
  $queryCount = 'SELECT count(DISTINCT comments.id) as "numComments" FROM comments, users, events WHERE users.id = comments.user_id AND comments.event_id = ?';
  $executeCountArray = array($eventID);

  $stmt = $db->prepare($queryCount);
  $stmt->execute($executeCountArray);
  $countComments = $stmt->fetchAll();

  $numComments = $countComments[0]['numComments'];

  $result = array_merge($comments, array($numComments));
 
  return $result;
}

function addCommentToEvent($eventID, $userID, $comment){
	global $db;
	$date = date('Y-m-d H:i:s');

	$stmt = $db->prepare('INSERT INTO comments(user_id, event_id, comment, data) VALUES (?, ?, ?, ?)');
	$stmt->execute(array($userID, $eventID, $comment, $date));
}
?>