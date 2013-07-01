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
               <td><?php echo $html_checkbox('akvoorwaarden', 'ja', 'I agree to <a href="#voorwaarden">the terms</a>') ?></td>
            </tr>

            <tr>
               <td></td>
               <td><?php echo $html_checkbox('akkosten', 'ja', 'I agree to the cost of &euro; <span class="kosten">30,00</span>') ?></td>
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
         <div id="voorwaarden">
            <h4>Artikel 1. Definitions</h4>

            In these Terms of Agreement the following definitions hold:
            <ul>
               <li>Introductory Camp: the introductory camp in the academic year 2013- 2014</li>
               <li>Deadline of Registration: there will be 2 deadlines for registration. The initial deadline will be at the 16th of August 2013. The final deadline will be at the 28th of August 2013.</li>
               <li>Cover: study association Cover</li>
               <li>IntroCie: the committee organizing the Introductory Camp</li>
               <li>Participation fee: the costs of enrollment, services and facilities as offered at the Introductory Camp.</li>
            </ul>
            <h4>Artikel 2. Applicability</h4>
            <ul>
               <li>These terms of agreement are applicable to: all participants of the Introductory Camp of Cover, organized by the IntroCie.</li>
               <li>Deviations from, and additions to, these terms of agreement are valid if and only if these are made known on the website of the IntroCie, or when they are explicitly, and written, agreed upon.</li>
            </ul>
            <h4>Artikel 3. Data</h4>
            <ul>
               <li>The IntroCie guarantees the correctness, completeness and reliability of the information he provides.</li>
               <li>In case of a dispute, the information published on the website of the IntroCie will be used as starting point.</li>
               <li>The content of the Introductory Camp is determined by the information as published on the website or other publications of the IntroCie. The IntroCie is not bound to any manifested errors or mistakes. The IntroCie cannot be held responsible for any content provided by third parties.</li>
               <li>The IntroCie will treat the data, provided by the participant on the participation form, in a confidential manner.</li>
            </ul>
            <h4>Artikel 4. Enrollment</h4>
            <ul>
               <li>The agreement between the IntroCie, respectively Cover and the participant comes about through registration on the website.</li>
               <li>The registration period is from the 1st of July 2013 until the 28th of August 2013. </li>
               <li>The date of confirmation is applied as date of registration.</li>
               <li>Enrollment obliges the participant to pay: the participation fee, services and facilities as far as provided. For further provisions on cancellation, see art. 7.</li>
               <li>During registration the participant is able to provide preferences with respect to the service and facilities provided by the IntroCie. The IntroCie cares to take these preferences into account as much as possible. No rights can be derived from this.</li>
            </ul>
            <h4>Artikel. 5. Further provisions with respect to enrollment</h4>
            <ul>
               <li>The initial deadline of registration will be at: the 16th of August 2013</li>
               <li>The final deadline of registration will be at the: 28th August 2013</li>
               <li>In case of over-enrollment at the initial deadline of registration, there will be a drawing of lots to decide the participants. First year students will have priority in this drawing. The IntroCie takes care of a fair drawing.</li>
               <li>When, after the initial deadline, there are still slots available, any subsequent enrollments will be handled on 'first come, first served'-basis, until the final deadline of registration.</li>
               <li>The IntroCie retains the right to, without giving reasons, provide (or deny) people with access to participate in the Introductory Camp.</li>
               <li>Enrollment, and all resulting obligations and rights, come to expire when a participant is not selected during the drawing in case of over-enrollment.</li>
               <li>In the case of misconduct, before or during the Introductory Camp, the IntroCie is free to exclude the concerning participant(s) from further participation of the camp. The participant(s) will still be obliged to pay the Participation fee to Cover.</li>
            </ul>
            <h4>Artikel 6. Payment</h4>
            <ul>
               <li>The Participation fee, barring printing or typing errors, will be the amount as published on the website of the IntroCie.</li>
               <li>Payment is done through authorizing Cover to collect amount as published on the website of the IntroCie.</li>
               <li>The payment will be collected after the Introductory Camp.</li>
               <li>The published amount applies per person and includes only the services and facilities as defined in the arrangements in the publications of the IntroCie.The level of the published amounts is based on prices of fuel, charges and taxes as known by the IntroCie at the moment of publication. De IntroCie retains the right to, until 20 days before the start of the Introductory Camp, increase the amount of payment as a result of an increase in the aforementioned prices. This right is extended to agreements already made. The increase will be no more than 15% of the total sum of the amounts.</li>
            </ul>
            <h4>Artikel 7. Cancellation</h4>
            <ul>
               <li>Cancellation of registration by the participant can only occur in writing, with reasons.</li>
               <li>In case of cancellation, the participant is still obliged to pay the Participation fee, barring special exceptions to be reviewed by the IntroCie. Only in case of cancellation before the initial deadline of registration there are no costs. After the initial deadline the participant is obliged the pay the following fees:</li>
               <ul>
                  <li>Cancellation before the initial deadline of registration (16th of August 2013): No costs.</li>
                  <li>Cancellation After the final deadline of registration (28th of August 2013): Full amount.</li>
                  <li>Cancellation between the initial deadline of registration (16th of August 2013) and before the final deadline of registration (28th of August 2013): Half amount.</li>
               </ul>
               <li>Immediate cancellation through odds does not remove any obligations from the participant to, after the deadline of registration, pay the Participation fee.</li>
            </ul>
            <h4>Artikel 8. Accountability</h4>
            <ul>
               <li>In case of accountability by the IntroCie, this accountability is limited to which is agreed in these terms of agreement.</li>
               <li>The IntroCie is not accountable for any damage as the result of:</li>
               <li>Shortcomings in the implementation of the agreement based on conditions which are attributable to the participant, including damage as a result of health conditions of the participant.</li>
               <li>Actions and influences of third parties, which are not related to the implementation of conditions.</li>
               <li>Conditions which are not due to the fault of the IntroCie and/or, under the law or standards in social interaction , cannot be reasonably attributed to the IntroCie.</li>
               <li>The IntroCie is not accountable for any damage of the participant due to incorrect or incomplete information provided by the IntroCie to the participant.</li>
               <li>The IntroCie is not accountable for any indirect or consequential damage as a result of actions of the participant, which is accountable to the participant due to standards in social interaction and to which there is a damage liability under the law.</li>
            </ul>
         </div>
      </form>
   <?php endif ?>
