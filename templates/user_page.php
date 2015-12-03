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
				<?php if(isLogged()): ?>
					<li><a id="link_hostingEvents" href="#hostingEvents">I'm Hosting ...</a></li>
					<li><a id="link_myEvents" href="#myEvents">I'm Going ...</a></li>
					<li><a id="link_invitedEvents" href="#invitedEvents">I'm Invited ...</a></li>
					<li><a id="link_otherEvents" href="#otherEvents">Other Events</a></li>
					<li><a id="link_customSearch" href="#customSearch" >Custom Search</a></li>
				<?php else: ?>
					<li><a id="link_customSearch" href="#customSearch" >Custom Search</a></li>
				<?php endif; ?>
			</ul>

			<form>
				<div id="myEvents" class="tab-section">
					<?php include('filter.php'); ?>
					<?php include('submit.php'); ?>
				</div>
			</form>
			<form>
				<div id="hostingEvents" class="tab-section">
					<?php include('filter.php'); ?>
					<?php include('submit.php'); ?>
				</div>
			</form>
			<form>
				<div id="invitedEvents" class="tab-section">
					<?php include('filter.php'); ?>
					<?php include('submit.php'); ?>
				</div>
			</form>
			<form>
				<div id="otherEvents" class="tab-section">
					<?php include('filter.php'); ?>
					<?php include('submit.php'); ?>
				</div>
			</form>
			<form>
				<div id="customSearch" class="tab-section">
					<?php include('filter.php'); ?>
					<?php include('customSearch.php'); ?>
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
