<?php

	if(!isset($_GET['userID'])){
		// On leaving the page, reset this session variable
		echo "really?";
		header('Location:'. 'index.php');
	}else{
		$_SESSION['currentUserPage'] = $_GET['userID'];
?>

	<div id="content">
		<div id="photo">
			<?php
				$photoURL = getUserImageURL($_GET['userID']);		
			?>
			<img src="<?= $photoURL ?>" alt="Profile Photo" width="200px" height="200px">
		</div>
		<div id="userInfo">
			<div id="">
			</div>
		</div>
		<div id="password_change">
			<button type="button" id="password_button">Change Password </button>
		</div>

		<div id="userEventTabs">
			<ul id="tabs">
				<li><a id="link_userHostedPublic" href="#hostedPublic">User's Public Hosted Events ...</a></li>
			</ul>

			<form>
				<div id="hostedPublic" class="tab-section">
					<?php include('filter.php'); ?>
				</div>
			</form>

			<ul id="event_list">
	
			</ul>

			<div id="page_buttons">

			</div>


		</div> <!-- End userEventTabs div  -->
	</div>	   <!-- End content div  -->
<?php } ?>
