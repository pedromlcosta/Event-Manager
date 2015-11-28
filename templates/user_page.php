<?php if(!isLogged()){
	//Not logged, redirecting or showing error message
	header("Location:" . 'index.php');
}else{ ?>
	<div id="content">
		<div id="photo">
			<?php
				$photoURL = getUserImageURL($_SESSION['userID']);

				if($photoURL === null)
					$photoURL = 'images/default_profile_pic.jpg';
				
			?>
			<img src="<?= $photoURL ?>" alt="Profile Photo" width="350px" height="350px">
		</div>
		<div id="user_info">
		</div>
		<div id="password_button">
		</div>
	</div>
<?php } ?>
