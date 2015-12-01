<div id="filter">
		<div class="sortSelection">
			<label><input type="radio" name="sortType" value="Date" checked="checked">Date</label>
			<label><input type="radio" name="sortType" value="Popularity">Popularity</label>
		</div>
		<div class="typeSelection">
			<?php
				$types = getTypes();

				for($i = 0; $i < count($types); $i++){
					echo ("<label><input type=\"checkbox\" name=\"type\" value=\"$types[$i]\" checked=\"checked\"> $types[$i] </label>");
				}
			?>
			

		</div>