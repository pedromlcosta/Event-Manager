<div id="filter">
		<div class="sortSelection">
			<h4 class="selTitle">Sort By:</h4>
			<label><input type="radio" name="sortType" value="Date" checked="checked">Date</label>
			<label><input type="radio" name="sortType" value="Popularity">Popularity</label>
			<label><input type="radio" name="sortType" value="Type">Type</label>
		</div>
		<div class="typeSelection">
			<h4 class="selTitle">Filters:</h4>
			<?php
				$types = getTypes();

				for($i = 0; $i < count($types); $i++){
					echo ("<label><input type=\"checkbox\" name=\"type\" value=\"$types[$i]\" checked=\"checked\"> $types[$i] </label>");
				}
			?>
			

		</div>