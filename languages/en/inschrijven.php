<?php

$fields = array(
   'voornaam' => 'First name',
   // 'tussenvoegsel' => 'insertion',
   'achternaam' => 'Last name',
   'adres' => 'Address',
   'postcode' => 'Postal code',
   'woonplaats' => 'City',
   'telefoonnummer' => 'Phone number',
   'thuisnummer' => 'Home phone number',
   'email' => 'Email',
   'rekeningnummer' => 'Account'
);

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

   <h2>Congratulations!</h2>
   <p>You have succesfully signed up for the camp. If correct, you have received a confirmation email with your information.</p>
   <p>We ask you to check this information and if you find any incorrect details, please send an email to <a href="mailto:introcie@svcover.nl">the IntroCie</a>.</p>

<?php elseif ($inschrijving == "Error"): ?>

   <h2>Sign up for Introcamp</h2>
   <p>An error has occured. Please inform <a href="mailto:introcie@svcover.nl">the IntroCie</a> as soon as possible so we can fix this. Thank you!</p>
   <pre><?php echo mysql_error() ?></pre>

<?php elseif (inschrijving_gesloten()): ?>

   <h2>Sign up for Introcamp</h2>
   <p>Unfortunately, it is no longer possible to sign up for the camp. Please send an email to <a href="mailto:introcie@svcover.nl">the IntroCie</a> to check whether it is possible to arrange something.</p>

<?php elseif (!inschrijving_geopend()): ?>

   <h2>Sign up for Introcamp</h2>
   <p>Soon you will be able to sign up for the camp.</p>

<?php else: ?>

   <h2>Sign up for Introcamp</h2>
   <form method="POST" action="index.php#inschrijven">
   
   <?php if ($inschrijving): ?>
   <p class="error">You have made an error in the form.</p>
   <?php endif ?>
   
   <table>
   <?php foreach($fields as $field => $label)
   {
      printf('
         <tr>
            <td>%s</td>
            <td><input type="text" name="%s" value="%s" class="%s"></td>
         </tr>',
            $label,
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
         <td>Study</td>
         <td><?php echo $html_select('opleiding', array(
            'KI' => 'Artificial Intelligence',
            'INF' => 'Computer Science',
            'Anders' => 'Other')) ?></td>
      </tr>
      
      <tr>
         <td>Participant type</td>
         <td><?php echo $html_select('deelnemer', array(
            'sjaars' => 'First year student',
            'ouderejaars' => 'Ouderejaars',
            'mentor' => 'Mentor')) ?></td>
      </tr>
      
      <tr>
         <td></td>
         <td><?php echo $html_checkbox('vega', 'ja', 'I am a vegetarian') ?></td>
      </tr>

      <tr>
         <td></td>
         <td><?php echo $html_checkbox('akvoorwaarden', 'ja', 'I agree to the terms') ?></td>
      </tr>

      <tr>
         <td></td>
         <td><?php echo $html_checkbox('akkosten', 'ja', 'I agree to the cost of &euro; XX.00') ?></td>
      </tr>
   
      <tr>
         <td colspan="2">Comments (allergies, medication, etc.)</td>
      </tr>
      <tr>
         <td colspan="2"><textarea rows="4" name="mededeling"><?php if (isset($_POST['mededeling'])) echo htmlspecialchars($_POST['mededeling'], ENT_COMPAT, 'utf-8') ?></textarea></td>
      </tr>

      <tr>
         <td colspan="2"><button type="submit">Sign up</button></td>
      </tr>
   </table>
   </form>
<?php endif ?>
