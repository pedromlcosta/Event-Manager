<?php

	if(!isset($_GET['userID'])){
		// On leaving the page, reset this session variable
		echo "really?";
		header('Location:'. 'index.php');
	}else{
		$_SESSION['currentUserPage'] = $_GET['userID'];
?>

<script src="scripts/users.js"></script>
<div id="changeNameForm">
	<div id="inputFieldOldName">
 		<input type="text" id="oldUserName"   placeholder="Current UserName">
 	</div>
 	<div id="inputFielNewName">
 		<input type="text" id="newUserName"   placeholder="New UserName">
 	</div>
</div>
<div id="changePassWord">
	<div id="inputFieldOldPass">
 		<input type="password" id="oldPass"   placeholder="Current password">
 	</div>
 	<div id="inputFielNewPass">
 		<input type="password" id="newPass"   placeholder="New password">
 	</div>
 	<div id="typeAgainNewPass">
 		<input type="password" id="typeAgainPass"   placeholder="Confirm New password">
 	</div>
</div>
<script type="text/javascript">
	handlers();
</script>

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
		<?php
		if(isLogged()){
			if($_SESSION['userID'] == $_GET['userID']){?> 
	 
		<div id="username_change">
			<button type="button" id="username_button">Change Username </button>
		</div>
		
		<div id="fullName_change">
			<button type="button" id="fullName_button">Change Full Name </button>
		</div>
		
		<div id="password_change">
			<button type="button" id="password_button">Change Password </button>
		</div>
		<?php
				}
		}?>
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
