<form action="" method="POST">
	<div class="grid_4">
		<img src="$IMGURL" onerror="imgError(this);" width="100%" />
	</div>

	<div class="grid_4">
		<h3>Daten zum Produkt erfassen</h3>
		$FORM

		<input type="submit" value="Speichern" />
	</div>

	<div class="labels grid_4">
		<h3>Labels erfassen</h3>
		$LABELS
		<div id="addLabel">
			+ Label
			<form>
				<input id="add_label" name="add_value" type="text" />
			</form>
			<div id="searchlabels">

			</div>
		</div>

		<br />
		<p><a href="true/do/delete">Produkt L&ouml;schen</a></p>
	</div>


</form>