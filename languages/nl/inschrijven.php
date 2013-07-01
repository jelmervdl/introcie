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
               <td><?php echo $html_checkbox('akkosten', 'ja', 'Ik ga akkoord met de kosten &euro; <span class="kosten">30,00</span>') ?></td>
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

            Algemene voorwaarden introkamp SV Cover.                                       

            <h4>Artikel 1. Definities</h4>


            De met hoofdletters aangegeven definities hebben in het kader van deze algemene voorwaarden de volgende betekenis:
            <ul>
               <li>Introkamp: betreft het introkamp voor het studiejaar 2013- 2014</li>
               <li>Inschrijfdeadline: er zullen 2 deadlines zijn voor de inschrijvingen. De initiële deadline is op 16 augustus 2013. De uiterste deadline op 28 augustus 2013.</li>
               <li>Cover: de studievereniging Cover</li>
               <li>IntroCie: de commissie die het introkamp organiseert</li>
               <li>Machtiging: de schriftelijke verklaring waarbij de deelnemer SV Cover machtigd om het deelnemersbedrag voor het introkamp af te schrijven.</li>
               <li>Deelnemersbedrag: de kosten van de inschrijving, de diensten en de voorzieningen zoals deze aangeboden worden tijdens het introkamp. </li>
            </ul>
            <h4>Artikel 2. Toepasselijkheid</h4>
            <ul>
               <li>Deze algemene voorwaarden zijn van toepassing op: alle deelnemers aan het Introkamp van Cover, georganiseerd door de IntroCie.</li>
               <li>Afwijkingen van, en aanvullingen op, deze algemene voorwaarden zijn slechts geldig indien deze uitdrukkelijk en schriftelijk zijn overeengekomen of voortijdig via de website van de IntroCie bekend zijn gemaakt.  </li>
            </ul>
            <h4>Artikel 3. Gegevens</h4>
            <ul>
               <li>De IntroCie staat in voor de juistheid, volledigheid en de betrouwbaarheid van de door hem verstrekte informatie.</li>
               <li>De informatie zoals deze op de website van de IntroCie is gepubliceerd, geldt als uitgangspunt bij een geschil. </li>
               <li>De inhoud van het introkamp wordt bepaald door de gegevens zoals deze op de website staan of in andere publicaties van de IntroCie. Kennelijke fouten of vergissingen van de IntroCie binden de IntroCie niet. De IntroCie kan niet worden gehouden aan de inhoud van voorlichtingsmateriaal dat is uitgegeven door derden.</li>
               <li>De IntroCie behandeld de gegevens, zoals die worden ingevuld op het inschrijfformulier op een vertrouwelijke manier. </li>
            </ul>
            <h4>Artikel 4. Inschrijving</h4>
            <ul>
               <li>De overeenkomst tussen de IntroCie, respectievelijk SV Cover en deelnemer komt tot stand door middel van inschrijving via de website. </li>
               <li>De inschrijfperiode loopt van 1 juli 2013 tot en met 28 augustus 2013. </li>
               <li>De datum van bevestiging geldt als datum van inschrijving.  </li>
               <li>Inschrijving verplicht de deelnemer tot betaling van: inschrijfgeld, diensten en voorziening voor zover genoten. Voor verdere bepalingen over annulering, zie art 7.</li>
               <li>Bij de inschrijving kan  de deelnemer bijzondere voorkeuren mbt de te leveren diensten kenbaar maken. De IntroCie draagt zorg om waar mogelijk rekening te houden met deze voorkeuren. Hieraan kunnen geen rechten worden ontleend.</li>
            </ul>
            <h4>Artikel. 5. Nadere bepalingen met betrekking tot inschrijving</h4>
            <ul>
               <li>De initiële Inschrijfdeadline staat op: 16 augustus 2013</li>
               <li>De uiterste Inschrijfdeadline staat op: 28 augustus 2013</li>
               <li>In het geval van overinschrijving op het moment van de initiële Inschrijfdeadline, zal onder de deelnemers worden geloot. Hierbij krijgen eerstejaars deelnemers voorrang. De IntroCie draagt zorg voor een eerlijk verloop van de loting. </li>
               <li>Indien na de initiële Inschrijfdeadline nog plekken beschikbaar zijn, wordt het "first come first served" principe aangehouden tot het verstrijken van de uiterste Inschrijfdeadline.</li>
               <li>De IntroCie behoudt zich het recht om, zonder opgaaf van reden, mensen toegang te geven (of ontzeggen) voor deelname aan het kamp.</li>
               <li>De inschrijving, en alle daaruit voortvloeiende verplichtingen en rechten, vervallen als de ingeschrevene bij een overinschrijving uitgeloot wordt.</li>
               <li>In het geval van wangedrag, voor of tijdens  het IntroKamp, staat het de IntroCie vrij om de persoon of personen in kwestie per direct van verdere deelname uit te sluiten. De deelnemer blijft het bedrag verschuldigd aan Cover.</li>
            </ul>
            <h4>Artikel 6. Betaling</h4>
            <ul>
               <li>Het bedrag is, behoudens druk- of typfouten, het bedrag zoals aangegeven op de website of andere publicaties van de IntroCie</li>
               <li>Betaling geschiedt door Cover te machtigen het bedrag zoals gepubliceerd op de website.</li>
               <li>Het bedrag zal worden afgeschreven na afloop van het kamp. </li>
               <li>Het gepubliceerde bedrag geldt per persoon en omvat alleen de diensten en voorzieningen zoals deze in de arrangementen in de publicaties van de IntroCie zijn omschreven. De hoogte van de gepubliceerde bedragen is gebaseerd op prijzen, brandstofprijzen, heffingen en belastingen, zoals die bij de IntroCie bekend waren op het moment van het in druk geven van de publicatie. De IntroCie behoudt zich het recht voor om, ook met betrekking tot reeds aangegane overeenkomsten, tot 20 dagen voor de dag van aanvang, het bedrag te verhogen als gevolg van verhogingen in de hiervoor genoemde prijzen. De verhoging zal maximaal 15% van de totale som bedragen.</li>
            </ul>
            <h4>Artikel 7. Annulering</h4>
            <ul>
            <li>Annulering van de inschrijving door de deelnemer dient schriftelijk, met opgaaf van reden, te gebeuren.</li>
            <li>Bij annulering is de deelnemer in ieder geval een deel van de kosten verschuldigd, behoudens bijzondere uitzondering ter beoordeling van de IntroCie. Alleen bij annulering voor het sluiten van de inschrijfdatum zijn er geen kosten. Daarna is de deelnemer ten hoogste de deelnamekosten verschuldigd.</li>
            <ul>
               <li>Annulering voor de initiële Inschrijfdeadline (16 augustus 2013): Geen kosten.</li>
               <li>Annulering na de uiterlijke Inschrijfdeadline (28 augustus 2013): Volledige Deelnemersbedrag.</li>
               <li>Annulering tussen na de initiële Inschrijfdatum (16 augustus 2013) en voor de uiterlijke Inschrijfdeadline (28 augustus 2013): Halve Deelnemersbedrag.</li>
            </ul>
            <li>Onverwijlde annulering door een overmacht situatie, ontslaat deelnemer niet van zijn verplichting, om na sluiting van de inschrijfperiode, de deelnamekosten te betalen. </li>
         </ul>
         <h4>Artikel 8. Aansprakelijkheid</h4>
         <ul>
            <li>Indien de IntroCie aansprakelijk mocht zijn, dan is deze aansprakelijkheid beperkt tot hetgeen in deze bepaling is geregeld</li>
            <li>De IntroCie is niet aansprakelijk voor schade die het gevolg is van:</li>
            <li>tekortkomingen in de uitvoering van de overeenkomst op grond van omstandigheden die zijn toe te rekenen aan de deelnemer, waaronder begrepen schades die het gevolg zijn van de gezondheidsconditie van de deelnemer;</li>
            <li>handelingen en invloeden van niet direct bij de uitvoering van de omstandigheden betrokken derden; </li>
            <li>omstandigheden die niet te wijten zijn aan de schuld van de IntroCie en/of krachtens de wet of de in het maatschappelijk verkeer geldende normen niet in redelijkheid aan de IntroCie kunnen worden toegerekend</li>
            <li>De IntroCie is niet aansprakelijk voor schade van de deelnemer die ontstaat doordat de IntroCie aan deelnemer onjuiste of onvolledige informatie heeft verstrekt. </li>
            <li>De Introcie is niet aansprakelijk voor enige gevolgschade of indirecte schade die het gevolg is van een handeling van de deelnemer, die krachtens het in het maatschappelijk verkeer aan hem is toe te rekenen en waartoe een schadeverplichting krachtens de wet bestaat. </li>
         </ul>

      </div>
   </form>
<?php endif ?>
