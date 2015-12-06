<?php
include_once('init.php');
include_once('database/users.php');
include_once('database/usersEvent.php');

$rep = array('val' => 'User Not Found');

if(isset($_POST['user']) && isset($_POST['eventID'])){
	$event = $_POST['eventID'];
	$user = $_POST['user'];
	$author = $_POST['userID'];

	$userId = getUserIDFull($user);

	if($userId == $author)
		$rep = array('val' => 'You cannot invite yourself');
	else{

		if($userId){
			if(isInvited($event,$userId) || isAttending($event,$userId)){
				$rep = array('val' => 'Already invited or attending');
			}
			else{
				inviteUserToEvent($event,$userId);
				$rep = array('val' => 'Valid', 'user' => $user);
			}
		}
	}
}
echo json_encode($rep);
?>