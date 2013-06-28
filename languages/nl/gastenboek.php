<h2>Gastenboek</h2>

<form method="post" action="gastenboek.php">
	<label class="gastenboek-naam">
		<span>Naam</span>
		<input type="text" name="naam">
	</label>
	
	<label class="gastenboek-email">
		<span>Email</span>
		<input type="text" name="email">
	</label>
	
	<label class="gastenboek-bericht">
		<span>Bericht</span>
		<textarea name="bericht"></textarea>
	</label>

	<label class="gastenboek-captcha">
		<span>De kleur van gras</span>
		<input type="text" name="captcha">
	</label>

	<button type="submit">Plaats bericht</button>
</form>

<div class="gastenboek">
	<!-- wordt extern geladen enzo -->
</div>

<button class="gastenboek-next-page-button">Meer berichten!</button>
