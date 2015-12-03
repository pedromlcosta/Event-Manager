<?php if(!isLogged()){
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
		<div id="userInfo">
			<div id="">
			</div>
		</div>
		<div id="password_change">
			<button type="button" id="password_button">Change Password </button>
		</div>

		<div id="userEventTabs">
			<ul id="tabs">
				<li><a id="link_hostingEvents" href="#hostingEvents">I'm Hosting ...</a></li>
			</ul>

			<form>
				<div id="hostingEvents" class="tab-section">
					<?php include('filter.php'); ?>
					<?php include('submit.php'); ?>
				</div>
			</form>

			<ul id="event_list">
	
			</ul>

			<div id="page_buttons">

			</div>


		</div> <!-- End userEventTabs div  -->
	</div>	   <!-- End content div  -->
<?php } ?>
