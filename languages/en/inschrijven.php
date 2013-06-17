<?php

$fields = array(
   'voornaam',
   'tussenvoegsel',
   'achternaam',
   'adres',
   'postcode',
   'woonplaats',
   'telefoonnummer',
   'thuisnummer',
   'email');

$inschrijving_gesloten = date('j') > 20 && date('n') > 5;

$html_select = function($name, array $options) use ($inschrijving)
{
   $html_options = array();

   foreach ($options as $value => $label)
      $html_options[] = sprintf('<option value="%s" %s>%s</option>',
         $value,
         isset($_POST[$name]) && $_POST[$name] == $value
            ? ' selected'
            : '',
         $label);

   return sprintf('<select name="%s" class="%s">%s</select>',
      $name,
      $inschrijving == $name
         ? 'error'
         : '',
      implode('', $html_options));
};

$html_checkbox = function($name, $value, $label) use ($inschrijving)
{
   return sprintf('<label class="%s"><input type="checkbox" name="%s" value="%s"%s> %s</label>',
      $inschrijving == $name
         ? 'error'
         : '',
      $name,
      $value,
      isset($_POST[$name]) && $_POST[$name] == $value
         ? ' checked'
         : '',
      $label);
};

?>

<?php if ($inschrijving == "True"): ?>

   <h2>Gefeliciteerd!</h2>
   <p>Je hebt je succesvol ingeschreven voor het kamp. We hebben je zojuist een e-mail gestuurd met daarin al je ingevulde gegevens en aanvullende informatie.</p>
   <p>We willen je vragen om alle gegevens te controleren en als er toch een fout in zit dit door te geven aan <a href="mailto:introcie@svcover.nl">de IntroCie</a>.</p>

<?php elseif ($inschrijving == "Error"): ?>

   <h2>Inschrijven Introkamp</h2>
   <p>Er is iets mis met de website. Neem alsjeblieft zo snel mogelijk contact op met <a href="mailto:introcie@svcover.nl">de IntroCie</a>.</p>
   <pre><?php echo mysql_error() ?></pre>

<?php elseif ($inschrijving_gesloten): ?>

   <h2>Inschrijven Introkamp</h2>
   <p>De inschrijvingen voor het kamp zijn helaas gesloten. Mocht je toch nog meewillen, <a href="mailto:introcie@svcover.nl">mail</a> de commissie om te zien of er iets te regelen is.</p>

<?php else: ?>

   <h2>Inschrijven Introkamp</h2>
   <form method="POST" action="index.php#inschrijven">
   
   <?php if ($inschrijving): ?>
   <p class="error">Je hebt een fout gemaakt bij het invullen van het formulier.</p>
   <?php endif ?>
   
   <table>
   <?php foreach($fields as $field)
   {
      printf('
         <tr>
            <td>%s</td>
            <td><input type="text" name="%s" value="%s" class="%s"></td>
         </tr>',
            ucfirst($field),
            $field,
            isset($_POST[$field])
               ? htmlentities($_POST[$field], ENT_QUOTES, 'utf-8')
               : '',
            $field == $inschrijving
               ? 'error'
               : ''
      );
   }
   ?>
      <tr>
         <td>Opleiding</td>
         <td><?php echo $html_select('opleiding', array(
            'KI' => 'Kunstmatige Intelligentie',
            'INF' => 'Informatica',
            'Anders' => 'Anders')) ?></td>
      </tr>
      
      <tr>
         <td>Soort deelnemer</td>
         <td><?php echo $html_select('deelnemer', array(
            'sjaars' => 'Eerstejaars',
            'ouderejaars' => 'Ouderejaars',
            'mentor' => 'Mentor')) ?></td>
      </tr>
      
      <tr>
         <td></td>
         <td><?php echo $html_checkbox('vega', 'ja', 'Ik ben vegetariër') ?></td>
      </tr>

      <tr>
         <td></td>
         <td><?php echo $html_checkbox('akvoorwaarden', 'ja', 'Ik ga akkoord met de voorwaarden') ?></td>
      </tr>

      <tr>
         <td></td>
         <td><?php echo $html_checkbox('akkosten', 'ja', 'Ik ga akkoord met de kosten &euro; XX.00') ?></td>
      </tr>
   
      <tr>
         <td colspan="2">Mededelingen (allergiën, medicijnen, opmerkingen)</td>
      </tr>
      <tr>
         <td colspan="2"><textarea name="mededeling"><?php if (isset($_POST['mededeling'])) echo htmlspecialchars($_POST['mededeling'], ENT_COMPAT, 'utf-8') ?></textarea></td>
      </tr>

      <tr>
         <td colspan="2"><button type="submit">Inschrijven</button></td>
      </tr>
   </table>
   </form>
<?php endif ?>
