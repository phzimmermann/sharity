
<div class="grid_12">
	<p>Aktueller Status: $STATUS</p>

	<form action="" method="post">
		<input type="hidden" name="status" value="yes" />
		<input type="submit" value="Ja" />
	</form>

	<form action="" method="post">
		<input type="hidden" name="status" value="wrongdate" />
		<input type="submit" value="Bitte anderes Datum w&auml;hlen" />
	</form>

	<form action="" method="post">
		<input type="hidden" name="status" value="no" />
		<input type="submit" value="Nein" />
	</form>

	<form action="" method="post">
		<input type="hidden" name="status" value="pending" />
		<input type="submit" value="In Abkl&auml;rung" />
	</form>
</div>