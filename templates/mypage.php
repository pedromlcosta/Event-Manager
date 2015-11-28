<?php if(!isLogged()){
	//Not logged, redirecting or showing error message
	header("Location:" . '');
}else{ ?>
	<div id="content">
		<div id="photo">
			<img src="" alt="User Profile Photo">
		</div>
		<div id="user_info">
		</div>
		<div id="password_button">
		</div>
	</div>
<?php } ?>
