<h2>Guestbook</h2>

<form method="post" action="gastenboek.php">
	<label class="gastenboek-naam">
		<span>Name</span>
		<input type="text" name="naam">
	</label>
	
	<label class="gastenboek-email">
		<span>Email</span>
		<input type="text" name="email">
	</label>
	
	<label class="gastenboek-bericht">
		<span>Message</span>
		<textarea name="bericht"></textarea>
	</label>

	<label class="gastenboek-captcha">
		<span>The color of grass</span>
		<input type="text" name="captcha">
	</label>

	<button type="submit">Post message</button>
</form>

<div class="gastenboek">
	<!-- wordt extern geladen enzo -->
</div>

<button class="gastenboek-next-page-button">More messages!</button>
