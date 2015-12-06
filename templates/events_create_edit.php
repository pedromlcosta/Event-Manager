<?php

if (isset($_POST['action']) && isLogged()) {
    
    if ($_POST['action'] == 'edit') {
        

        $path         = "action_editEvents.php";
        $button       = "Edit";
        $eventID      = $_POST['id'];
        $required     = "";
        $event        = getEventByID($eventID);
        $title        = $event['title'];
        $fullText     = $event['fulltext'];
        $data         = $event['data'];
        $eventPrivate = $event['private'];
        $eventTags    = "";
        $tagIDs       = getTagWithEvent($eventID);
        if($eventPrivate==1)
            $checked="checked";
        else
            $checked="";
        
        $sizeOfArray = count($tagIDs);
        for ($i = 0; $i < $sizeOfArray; $i++) {
            $tagId = $tagIDs[$i];
            
            if ($i < $sizeOfArray - 1)
                $eventTags = $eventTags . getTagDesc($tagId['tag_id']) . " ";
            else
                $eventTags = $eventTags . getTagDesc($tagId['tag_id']);
        }
    }
    
    if ($_POST['action'] == 'create') {
        $path         = "action_createEvents.php";
        $button       = "Create";
        $title        = "";
        $fullText     = "";
        $data         = "";
        $eventTags    = "";
        $required     = "required";
        $eventPrivate = 0;
        $eventID      = "";
        $checked="";
    }
        
?>
   

 
     <form id="eventEditAdd" action="<?php echo $path ?>" method="post">
  <fieldset>
    <legend>Event</legend>
    <div>
      <label>Title:
        <input type="text" name="title" id="title" value="<?=$title?>" required>
   </label>
   </div>
   <div id="createSelectType">
    <label>Type:
    <select name="Event Type">
      <?php
      $types = getTypes();
       for($i = 0; $i < count($types); $i++){
        echo ("<option name='type' value=$types[$i] > $types[$i] </option>");
      }
      ?>
    </select>
    <label>
  </div>
   <div id="privateCheckbox">
    <label>Private:
      <input type="checkbox" name="private" id="private"> 
  </label>
   </div>
   <div>
     <label>Text:
     <textarea name="fullText" id="fullText" required><?=$fullText?></textarea>
     </label>
   </div>
   <div>
     <label for="eventTags">Tags:</label>
     <textarea name="eventTags" id="eventTags" required><?=$eventTags?></textarea>
   </div>
   <div>
     <label for="data">Date:</label>
     <input type="date" name="data" id="data" value="<?=$data?>"required>  
   </div>
   <div>
    <label>Photo:
     <input type="file" name="eventImg" id="eventImg" <?php echo $required?> >
   </label>
   </div>
   <div id="hidden">
    <input type="hidden" name="eventID" id="eventID" value="<?php echo $eventID?>"> 
  </div>
  <div class="button">
   <button type="submit"> <?php echo $button?></button>
 </div>
</fieldset>
</form>
<?php
}
?>