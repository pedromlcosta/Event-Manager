<?php 
    include_once('init.php');
    include_once('genericStart.html');
    include_once('database/events.php');
    include_once('database/users.php');
    include_once('database/usersEvent.php');
    include_once('database/tagEvent.php');
    include_once('database/tag.php');
?>

<script src="scripts/script.js"></script>
<script src="scripts/events.js"></script>

<?php
    include_once('templates/header.php');
    include_once('templates/events_create_edit.php');
    include_once('templates/footer.php');
?>