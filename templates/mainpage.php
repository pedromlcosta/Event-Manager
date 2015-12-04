<div id="mainPage">
 <!-- IF IS ON USER PAGE, USE ONLY A PART OF THIS? OR COPY IT TO USER_PAGE-->
	<ul id="tabs">
		<?php if(isLogged()): ?>
		<li><a id="link_hostingEvents" href="#hostingEvents">I'm Hosting ...</a></li>
		<li><a id="link_myEvents" href="#myEvents">I'm Going ...</a></li>
		<li><a id="link_invitedEvents" href="#invitedEvents">I'm Invited ...</a></li>
		<li><a id="link_otherEvents" href="#otherEvents">All Events</a></li>
		<li><a id="link_customSearch" href="#customSearch" >Custom Search</a></li>
	<?php else: ?>
	<li><a id="link_customSearch" href="#customSearch" >Custom Search</a></li>
<?php endif; ?>
</ul>
<form>
<div id="myEvents" class="tab-section">
	<?php include('filter.php'); ?>
</div>
</form>
<form>
<div id="hostingEvents" class="tab-section">
	<?php include('filter.php'); ?>
</div>
</form>
<form>
<div id="invitedEvents" class="tab-section">
	<?php include('filter.php'); ?>
</div>
</form>
<form>
<div id="otherEvents" class="tab-section">
	<?php include('filter.php'); ?>
</div>
</form>
<form>
<div id="customSearch" class="tab-section">
	<?php include('filter.php'); ?>
	<?php include('customSearch.php'); ?>
</div>
</form>
<ul id="event_list">
	
</ul>
<div id="page_buttons">

</div>
</div>