
<div class="grid_8">
	<h2>Ausleihen</h2>
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

	<form action="" method="post">
		<input type="hidden" name="status" value="sent" />
		<input type="submit" value="Gesendet" />
	</form>

	<form action="" method="post">
		<input type="hidden" name="status" value="completed" />
		<input type="submit" value="Abgeschlossen" />
	</form>
</div>

<div class="grid_4">
	<h2>Ausleiher</h2>
	$LENDER
	<p>
	Lieferadresse:<br />
	<pre>$ADDRESS</pre>
	</p>

</div>