<?php

 $delimiters="[\s,\/,\|]";
 $imageExtension =array('jpg','png','jpeg','gif');
 $maxDistance=2;

  function isLogged(){
    return isset($_SESSION['userID']);
  }
?>