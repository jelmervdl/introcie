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
   'email',
   'rekeningnummer');

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

<?php elseif (inschrijving_gesloten()): ?>

   <h2>Inschrijven Introkamp</h2>
   <p>De inschrijvingen voor het kamp zijn helaas gesloten. Mocht je toch nog meewillen, <a href="mailto:introcie@svcover.nl">mail</a> de commissie om te zien of er iets te regelen is.</p>

<?php elseif (!inschrijving_geopend()): ?>

   <h2>Inschrijven Introkamp</h2>
   <p>De inschrijvingen voor het kamp gaan binnenkort open.</p>

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
         <td><?php echo $html_checkbox('akvoorwaarden', 'ja', 'Ik ga akkoord met <a href="#voorwaarden">de voorwaarden</a>') ?></td>
      </tr>

      <tr>
         <td></td>
         <td><?php echo $html_checkbox('akkosten', 'ja', 'Ik ga akkoord met de kosten &euro; XX.00') ?></td>
      </tr>
   
      <tr>
         <td colspan="2">Mededelingen (allergiën, medicijnen, opmerkingen)</td>
      </tr>
      <tr>
         <td colspan="2"><textarea rows="4" name="mededeling"><?php if (isset($_POST['mededeling'])) echo htmlspecialchars($_POST['mededeling'], ENT_COMPAT, 'utf-8') ?></textarea></td>
      </tr>

      <tr>
         <td colspan="2"><button type="submit">Inschrijven</button></td>
      </tr>
   </table>
   <div id="voorwaarden">
      <h2>Voorwaarden</h2>
      
      <h3>Totstandkoming overeenkomst</h3>

      <p>De dag van digitale ofwel schriftelijke inschrijving is de dag waarop de overeenkomst van kracht wordt.</p>
      <p>Inschrijving verplicht tot betaling.</p>
      <p>De initiële inschrijfdeadline staat op 16 augustus 2013. In het geval van overinschrijving op het moment van de deadline zal onder de deelnemers worden geloot. Hierbij krijgen eerstejaars deelnemers voorrang. Indien na de deadline nog plekken beschikbaar zijn, wordt het "first come first served" principe aangehouden. De IntroCie behoudt zich het recht om, zonder opgaaf van reden, mensen toegang te geven (of ontzeggen) voor deelname aan het kamp.</p>
      <p>De inschrijving, en alle daaruit voortvloeiende verplichtingen en rechten, vervallen als de ingeschrevene bij een overinschrijving uitgeloot wordt.</p>
      <p>De inhoud van het introkamp wordt bepaald door de gegevens zoals deze op de website staan of in andere publicaties van de IntroCie. Kennelijke fouten of vergissingen van de IntroCie binden de IntroCie niet. De IntroCie kan niet worden gehouden aan de inhoud van voorlichtingsmateriaal dat is uitgegeven door derden.</p>
      <p>Indien de deelnemer bij het tot stand komen van de overeenkomst bepaalde voorkeuren kenbaar maakt met betrekking tot de door de IntroCie te leveren diensten zal met opgegeven voorkeuren rekening worden gehouden. Hieraan kunnen geen rechten worden ontleend.</p>
      <p>In het geval van wangedrag staat het de IntroCie vrij om de persoon of personen in kwestie per direct van verdere deelname uit te sluiten. De deelnemer blijft het bedrag verschuldigd aan de vereniging (Cover).</p>

      <h3>Betaling</h3>

      <p>Aan druk- of typefouten kunnen geen rechten worden ontleend.</p>
      <p>Betaling geschiedt door Cover te machtigen het bovengenoemde bedrag af te schrijven. Het bedrag zal afgeschreven worden na afloop van het kamp.</p>

      <h3>Het bedrag</h3>

      <p>Het gepubliceerde bedrag geldt per persoon en omvat alleen de diensten en voorzieningen zoals deze in de arrangementen in de publicaties van de IntroCie zijn omschreven.</p>
      <p>De hoogte van de gepubliceerde bedragen is gebaseerd op prijzen, brandstofprijzen, heffingen en belastingen, zoals die bij de IntroCie bekend waren op het moment van het in druk geven van de publicatie. De IntroCie behoudt zich het recht voor om, ook met betrekking tot reeds aangegane overeenkomsten, tot 20 dagen voor de dag van aanvang, het bedrag te verhogen als gevolg van verhogingen in de hiervoor genoemde prijzen. De verhoging zal maximaal 15% van de totale som bedragen.</p>


      <h3>Annulering door de deelnemer</h3>

      <p>Annulering van de overeenkomst door de deelnemer dient schriftelijk te geschieden. Bij annulering is de deelnemer in elk geval een deel van de kosten verschuldigd aan de IntroCie. Dit bedrag hangt af van de datum van de afmelding, namelijk:</p>
      <ul>
         <li>Annulering voor de initiële inschrijfdeadline (16 augustus 2013): Geen kosten.</li>
         <li>Annulering tussen de deadlines in (16 tot en met 27 augustus 2013): Helft van overeengekomen deelnamekosten.</li>
         <li>Annulering na de uiterlijke inschrijfdeadline (28 augustus 2013): Deelnamekosten zoals overeengekomen.</li>
      </ul>


      <h3>Aansprakelijkheid van de IntroCie</h3>

      <p>De IntroCie is niet aansprakelijk voor schade die het gevolg is van:</p>
      <ul>
         <li>tekortkomingen in de uitvoering van de overeenkomst op grond van omstandigheden die zijn toe te rekenen aan de deelnemer, waaronder begrepen schades die het gevolg zijn van de gezondheidsconditie van de deelnemer;</li>
         <li>handelingen en invloeden van niet direct bij de uitvoering van de omstandigheden betrokken derden;</li>
         <li>omstandigheden die niet te wijten zijn aan de schuld van de IntroCie en/of krachtens de wet of de in het maatschappelijk verkeer geldende normen niet in redelijkheid aan de IntroCie kunnen worden toegerekend.</li>
      </ul>
   </div>
   </form>
<?php endif ?>
