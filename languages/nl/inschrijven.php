<?php

if ($inschrijving == "True"){
   echo "<span class=\"titel\">Gefeliciteerd!</span><br /><br />";
   echo "Je hebt je succesvol ingeschreven voor het kamp. We hebben je zojuist een e-mail gestuurd met daarin al je ingevulde gegevens en aanvullende informatie.<br />";
   echo "We willen je vragen om alle gegevens te controleren en als er toch een fout in zit dit door te geven aan de <a href=\"mailto:introcie@svcover.nl\">IntroCie</a>";
} else if((date('j') > 20) && (date('n') > 5)) {
   echo "<span class=\"titel\">Inschrijven Introkamp</span><br /><br />";
   echo "De inschrijvingen voor het kamp zijn helaas gesloten. Mocht je toch nog meewillen, <a href=\"mailto:introcie@svcover.nl\">mail</a> de commissie om te zien of er iets te regelen is.";
} else {
   echo "<span class=\"titel\">Inschrijven Introkamp</span><br /><br />";
   echo "<form method=\"POST\" action=\"index.php#inschrijven\">";
   if ($inschrijving){
      echo "<span class=\"error\">Je hebt een fout gemaakt bij het invullen van het formulier.</span><br />";
   }
   echo "<table>";
   $fields = array('voornaam', 'tussenvoegsel', 'achternaam', 'adres', 'postcode', 'woonplaats', 'telefoonnummer', 'thuisnummer', 'email');
   foreach($fields as $value){
      if ($value != $inschrijving){
         echo "<tr><td>".ucfirst($value)."</td><td><input name=\"".$value."\" type=\"text\" value=\"".$_POST[$value]."\"></td></tr>";
      } else {
         echo "<tr><td>".ucfirst($value)."</td><td><input name=\"".$value."\" class=\"error\" type=\"text\" value=\"".$_POST[$value]."\"></td></tr>";
      }
   }
   
   echo "<tr><td>Opleiding</td><td><select name=\"opleiding\">";
   echo "<option value=\"KI\"";
   if($_POST['opleiding'] == "KI"){
      echo 'selected="selected"';
   }
   echo ">Kunstmatige Intelligentie</option><option value=\"INF\"";
   if($_POST['opleiding'] == "INF"){
      echo 'selected="selected"';
   }
   echo ">Informatica</option><option value=\"Anders\"";
   if($_POST['opleiding'] == "Anders"){
      echo 'selected="selected"';
   }
   echo ">Anders</option></select></td></tr>";
   
   echo "<tr><td>Soort deelnemer</td><td><select name=\"deelnemer\">";
   echo "<option value=\"sjaars\"";
   if($_POST['deelnemer'] == "sjaars"){
      echo 'selected="selected"';
   }
   echo ">Eerstejaars</option><option value=\"ouderejaars\"";
   if($_POST['deelnemer'] == "ouderejaars"){
      echo 'selected="selected"';
   }
   echo ">Ouderejaars</option><option value=\"mentor\"";
   if($_POST['deelnemer'] == "mentor"){
      echo 'selected="selected"';
   }
   echo ">Mentor</option></select></td></tr>"; 
   
   echo "<tr><td>Vegetari&euml;r</td><td><input type=\"checkbox\" name=\"vega\" value=\"ja\"";
   if ($_POST['vega'] == TRUE){
      echo "CHECKED";
   }
   echo "></td></tr>";
   echo "<tr><td colspan=\"2\">Mededelingen (allergi&euml;n, medicijnen, opmerkingen)</td></tr><tr><td colspan=\"2\"><textarea rows=\"5\" cols=\"60\" name=\"mededeling\">".$_POST['mededeling']."</textarea></td></tr>";
   echo "<tr><td colspan=\"2\"><input type=\"submit\" value=\"Inschrijven\"></td></tr></table>";
   echo "</form>";
}
