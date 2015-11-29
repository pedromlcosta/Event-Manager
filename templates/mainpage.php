<div id="mainPage">
 <!-- IF IS ON USER PAGE, USE ONLY A PART OF THIS? OR COPY IT TO USER_PAGE-->
	<ul id="tabs">
		<?php if(isLogged()): ?>
		<li><a id="link_myEvents" href="#myEvents">My Events</a></li>
		<li><a id="link_hostingEvents" href="#hostingEvents">Hosting Events</a></li>
		<li><a id="link_invitedEvents" href="#invitedEvents">Invitations</a></li>
		<li><a id="link_otherEvents" href="#otherEvents">Other Events</a></li>
		<li><a id="link_customSearch" href="#customSearch" >Custom Search</a></li>
	<?php else: ?>
	<li><a id="link_customSearch" href="#customSearch" >Custom Search</a></li>
<?php endif; ?>
</ul>
<div id="myEvents" class="tab-section">
	<?php include('filter.php'); ?>
	<?php include('submit.php'); ?>
</div>
<div id="hostingEvents" class="tab-section">
	<?php include('filter.php'); ?>
	<?php include('submit.php'); ?>
</div>
<div id="invitedEvents" class="tab-section">
	<?php include('filter.php'); ?>
	<?php include('submit.php'); ?>
</div>
<div id="otherEvents" class="tab-section">
	<?php include('filter.php'); ?>
	<?php include('submit.php'); ?>
</div>
<div id="customSearch" class="tab-section">
	<?php include('filter.php'); ?>
	<?php include('customSearch.php'); ?>
	<?php include('submit.php'); ?>
</div>
<ul id="event_list">
	
</ul>
</div>