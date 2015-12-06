<?php

if (isset($_POST['action']) && isLogged()) {
    print_r($_POST);
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
   

    <form action="<?= $path ?>" id="inputForm" method="post">
        <fieldset>
            <legend>Event:</legend>
            <div>
                Title
                <input type="text" name="title" id="title" value="<?= $title ?>" required>
            </div>
            <div id="privateCheckbox">
                Private
                <input type="checkbox" name="private" id="private" "<= $checked?>">
            </div>
            <div>
         
            </div>
            <div id="createSelectType">
                <select name="Event Type" <?= $required ?>>
              <!--  <?php
                $types = getTypes();

                for($i = 0; $i < count($types); $i++){
                    echo ("<option name='type' value=".($i+1)." > $types[$i] </option>");
                }
                ?>-->


                </select>
            </div>
            <div>
                <label for="fullText">Text:</label>
                <textarea name="fullText" id="fullText" required><?= $fullText ?></textarea>
            </div>
            <div>
                <label for="eventTags">Tags:</label>
                <textarea name="eventTags" id="eventTags" required><?= $eventTags ?></textarea>
            </div>
            <div>
                <label for="data">Date:</label>
                <input type="date" name="data" id="data" value="<?= $data ?>" required>
            </div>
            <br>
            <div>
                <input type="file" name="eventImg" id="eventImg" <?= $required ?>> 
            </div>
            <div>
                <input type=hidden name="eventID" id="eventID" value="<?= $eventID ?>">
            </div>
            <br>
            <div class="button">
                <button type="submit">
                    <?= $button ?>
               </button>
                <!-- onclick="history.go(-1); .-->
            </div>
        </fieldset>
    </form>
<?php
}
?>