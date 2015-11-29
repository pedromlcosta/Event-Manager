<div id="filter">
		<div class="sortSelection">
			<label><input type="radio" name="sortType" value="Date" checked>Date</label>
			<label><input type="radio" name="sortType" value="Popularity">Popularity</label>
		</div>
		<div class="types">
			<?php
				$types = getTypes();

				for($i = 0; $i < count($types); $i++){
					echo ("<label><input type=\"checkbox\" name=\"type\" value=\" $types[$i] \" checked> $types[$i] </label>");
				}
			?>
			

		</div>