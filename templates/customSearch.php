      <form action="action_search.php" method="post">
            <div class="tagSelection">
              <label><h4 class="selTitle">Tags to Search:</h4>
             <textarea name="tagsToSearch" id="tagsToSearch" placeholder="Tags"></textarea></label>
            </div>
            <div class="dateSelection">
            <label for="dateTag"> <h4 class="selTitle">Date:</h4></label>
             <input type="date"  name="dateTag" id="dateTag" >  
            </div>
           <div id="button">
           <button type="submit"  >Search</button>
           </div>

      </form>
  ;

     
<?php
  include_once('init.php');
//$result=customSearch(2,'concerto',[], ["Party"],'Date', 3, 1);
?>
<a href="templates/printEvent.php?eventID=<?=1?>">Link To</a> 