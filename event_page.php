<?php
  include_once('init.php');
  include_once('database/events.php');
  include_once('database/users.php');
  include_once('database/usersEvent.php');
  require_once("ESAPI/src/ESAPI.php");
  require_once("ESAPI/src/reference/DefaultEncoder.php");
  include('genericStart.html');
?>
  
<script src="scripts/events.js"></script>

<?php

  include_once('templates/header.php');
  include_once('templates/event_page.php');
  include_once('templates/footer.php');
?>