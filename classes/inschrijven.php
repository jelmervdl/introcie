<?php

error_reporting('E_NONE');
Class inschrijven {

var $data;

public function process($data){
	
	$fields = array('voornaam', 'tussenvoegsel', 'achternaam', 'adres', 'postcode', 'woonplaats', 'telefoonnummer', 'thuisnummer', 'vega', 'deelnemer', 'opleiding', 'email', 'mededeling', 'betaald', 'akkosten', 'akvoorwaarden');
	$return = "True";
	$_POST['telefoonnummer'] = str_replace("+", "00", str_replace(" ", "", str_replace(".", "", str_replace("-", "", $_POST['telefoonnummer']))));
	$_POST['thuisnummer'] = str_replace("+", "00", str_replace(" ", "", str_replace(".", "", str_replace("-", "", $_POST['thuisnummer']))));
	
	if ($this->check_email_address($_POST['email']) == false){
		$return = "email";
	} else if (!is_numeric($_POST['telefoonnummer'])){
		$return = "telefoonnummer";
	} else if (!empty($_POST['thuisnummer']) && !is_numeric($_POST['thuisnummer'])){
		$return = "thuisnummer";
	} else { 
		$velden = "";
		$waarden = "";
		foreach($fields as $value){
			if (empty($_POST[$value]) && !($value == "mededeling") && !($value == "tussenvoegsel")){
				if (($value == "thuisnummer" && ($_POST['deelnemer'] == "mentor" || $_POST['deelnemer'] == "ouderejaars"))){
				} else if ($value != "vega"){
					$return = $value;
				}
			} else {
				$velden .= "`".$value."`, ";
				$waarden .= "'".htmlentities($_POST[$value], ENT_QUOTES, "UTF-8")."', ";
			}
		}
		if ($return == "True"){
			$velden = substr($velden, 0, -2);
			$waarden = substr($waarden, 0, -2);
			$query = "INSERT INTO `inschrijvingen` (".$velden.") VALUES (".$waarden.");";
			if (!$res = mysql_query($query)){
				$return = "Error";
			} else {
				$velden = explode("`, `", substr($velden, 1, -1));
				$waarden = explode("', '", substr($waarden, 1, -1));
				$table = "";
				foreach($velden as $key => $value){
					$table .= "<tr><td>".ucfirst($value).":</td><td>".$waarden[$key]."</td></tr>";
				}	
	
				$this->sendmail($_POST['email'], $_POST['voornaam'], $table);
			}
		}
	}
	return $return;
}

private function sendmail($mail, $naam, $table){

	$subject = 'Inschrijving Introkamp Cover';
	$message = "<html>
	<head>
		<title>Inschrijving Introkamp Cover</title>
	</head>
	<body>
		Beste ".$naam.", <br />
Je hebt je zojuist ingeschreven voor het introkamp van studievereniging Cover, daarom hierbij nog een laatste controle van de gegevens en wat aanvullende informatie.<br /><br />
De door jou ingevulde gegevens:<br />
		<table>
			".$table."
		</table><br />
		Klopt er iets niet? Geef het even door aan de IntroCie (reply op dit mailtje met de correcte informatie is voldoende).<br /><br/>
Het kamp vindt plaats van 31 augustus tot en met 2 september 2012, de 31e zal het kamp direct na de facultaire introductiedag beginnen en we zullen op 2 augustus in de loop van de middag terug zijn in Groningen. Het vervoer hebben wij geregeld. Op de heenreis vertrekken we vanaf de Bernoulliborg en na de terugreis zullen we afgezet worden op het centraal station in Groningen. Let dus op waar je je fiets neerzet. Voor de overige informatie verwijzen we je graag door naar de website.<br /><br />
Met vriendelijke groet, <br />
de IntroCie
	</body>
	</html>";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: IntroCie Cover <introcie@svcover.nl>' . "\r\n";

mail($mail, $subject, $message, $headers);

}


private function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}
}
?>
