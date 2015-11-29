<?php if(!isset($_GET['userID'])){
	//Not logged, redirecting or showing error message
	header("Location:" . 'index.php');
	die();
}else{ ?>
	<div id="content">
		<div id="photo">
			<?php
				$photoURL = getUserImageURL($_GET['userID']);		
			?>
			<img src="<?= $photoURL ?>" alt="Profile Photo" width="200px" height="200px">
		</div>
		<div id="user_info">
			<div id="">
			</div>
		</div>
		<div id="password_change">
			<button type="button" id="password_button">Change Password </button>
		</div>
	</div>
<?php } ?>
