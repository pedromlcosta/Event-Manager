<div id="customSearch">      
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
           <button type="submit" >Search</button>
        </div>

    </form>

    <a href="event_page.php?eventID=<?=1?>">Event 1 Test Link</a> 
</div>
