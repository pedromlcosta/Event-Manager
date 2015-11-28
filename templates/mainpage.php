<div id="mainPage">
	<ul id="tabs">
		<li><a href="#myEvents">My Events</a></li>
		<li><a href="#hostingEvents">Hosting Events</a></li>
		<li><a href="#invitedEvents">Invitations</a></li>
		<li><a href="#otherEvents">Other Events</a></li>
		<li><a href="#customSearch">Custom Search</a></li>
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
</div>