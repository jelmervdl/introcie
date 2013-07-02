<?php

Class Inschrijven
{
	public function process(array $input)
	{
		$fields = array(
			'voornaam',
			'tussenvoegsel',
			'achternaam',
			'adres',
			'postcode',
			'woonplaats',
			'telefoonnummer',
			'thuisnummer',
			'vega',
			'deelnemer',
			'opleiding',
			'email',
			'mededeling',
			// 'betaald',
			'rekeningnummer',
			'akkosten',
			'akvoorwaarden',
			'random_id');

		$optional = array('mededeling', 'tussenvoegsel', 'thuisnummer', 'vega');

		$is_oude_bekende = $input['deelnemer'] == "mentor" || $input['deelnemer'] == "ouderejaars";
		
		$input['telefoonnummer'] = $this->clean_phone_number($input['telefoonnummer']);
		$input['thuisnummer'] = $this->clean_phone_number($input['thuisnummer']);

		if (!$this->check_email_address($input['email']))
			return 'email';

		if (!ctype_digit($input['telefoonnummer']))
			return 'telefoonnummer';

		if (!empty($input['thuisnummer']) && !ctype_digit($input['thuisnummer']))
			return 'thuisnummer';

		if (!ctype_digit($input['rekeningnummer']))
			return 'rekeningnummer';

		$data = array();

		foreach($fields as $field)
		{
			if (empty($input[$field]) && !in_array($field, $optional) && !$is_oude_bekende)
				return $field;

			// Sommige velden zijn gewoon leeg (vega bijv, omdat checkbox) dus isset-test.
			$data[$field] = isset($input[$field]) ? $input[$field] : '';
		}

		$query = sprintf('INSERT INTO `inschrijvingen` (%s) VALUES (%s)',
			implode(', ', array_keys($data)),
			implode(', ', array_map(array($this, 'mysql_quote'), array_values($data))));

		// Gebruik UTF-8 voor de INSERT-query
		@mysql_query("SET NAMES 'utf8'");

		if (($res = mysql_query($query)) === false)
			return 'Error';
		
		$table_rows = array();

		foreach ($data as $field => $value)
		{
			// Sla random-id maar over, die hoeft er niet in
			if ($field == 'random_id')
				continue;

			$table_rows[] = sprintf('<tr><td>%s</td><td>%s</td></tr>',
				ucfirst($field),
				htmlentities($value, ENT_COMPAT, 'UTF-8'));
		}

		// Kopie voor de kamploper
		$this->sendmail($input['email'], $input['voornaam'], implode("\r\n", $table_rows));

		// Kopie voor de intocie backup
		$this->sendmail('introcie@svcover.nl', $input['voornaam'], implode("\r\n", $table_rows));
		
		return "True";
	}

	private function mysql_quote($value)
	{
		return sprintf("'%s'", mysql_real_escape_string($value));
	}

	private function sendmail($mail, $naam, $table)
	{
		$subject = 'Inschrijving Introkamp Cover';

		$message = include_translation('mail.php', compact('naam', 'table'));
		
		$headers = array(
			'MIME-Version: 1.0',
			'Content-type: text/html; charset=UTF-8',
			'From: IntroCie Cover <introcie@svcover.nl>');

		mail($mail, $subject, $message, implode("\r\n", $headers));
	}

	private function clean_phone_number($number)
	{
		return str_replace('+', '00', preg_replace('/[ \.-]/', '', $number));
	}

	private function check_email_address($email)
	{
		return preg_match('/^[^@]+@[^@]+\.[a-z]+$/i', $email);
	}

}
