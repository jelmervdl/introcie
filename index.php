<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', true);

include('classes/default.php');
include('classes/database.php');
include('classes/inschrijven.php');

$data = new data();
$class = new normal();
$inschrijven = new inschrijven();
$pagina = "Inschrijven";

$data->connect();

$class->data = $data;
$inschrijven->data = $data;
$class->titel = $pagina;
$class->gegevens = $class->gegevens();

$inschrijving = "";
if (!empty($_POST)){
   $inschrijving = $inschrijven->process($_POST);
}

header('Cache-control: private'); // IE 6 FIX

if(isSet($_GET['lang']))
{
   $lang = $_GET['lang'];

// register the session and set the cookie
   $_SESSION['lang'] = $lang;

   setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
   $lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
   $lang = $_COOKIE['lang'];
}
else
{
   $lang = 'nl';
}

switch ($lang) {
 case 'en':
 $lang_file = 'lang_en.php';
 break;

 case 'nl':
 $lang_file = 'lang_nl.php';
 break;

 default:
 $lang_file = 'lang_nl.php';

}

include_once 'languages/'.$lang_file;
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>
      <?php echo $lang['PAGE_TITLE']; ?>
   </title>
   <link rel="stylesheet" type="text/css" href="style.css">
   <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
   <link rel="icon" href="images/favicon.ico" type="image/x-icon">
   <script src="jquery-1.9.1.min.js" type="text/javascript" charset="utf-8">
   </script>   
   <script type="text/javascript" charset="utf-8">
   $(document).ready(function() {
      $("#banner .menu_li a").bind("click",function(event){
         event.preventDefault();
         var target = $(this).attr("href");
         $("html, body").stop().animate({
            scrollLeft: $(target).offset().left,
            scrollTop: $(target).offset().top
         }, 1200);
      });
   });
   </script>

</head>
<body>

   <div id="banner">

      <ul>
         <li class="menu_li">
            <a href="#home"><?php echo $lang['MENU_HOME']; ?></a>
         </li>  
         <li class="menu_li">   
            <a href="#kamp"><?php echo $lang['MENU_KAMP']; ?></a>
         </li>   
         <li class="menu_li">   
            <a href="#organisatie"><?php echo $lang['MENU_ORGANISATIE']; ?></a>
         </li>  
         <li class="menu_li">   
            <a href="#thema"><?php echo $lang['MENU_THEMA']; ?></a>
         </li>
         <li class="menu_li">
            <a href="#inschrijven"><?php echo $lang['MENU_INSCHRIJVEN']; ?></a>
         </li>
         <li class="menu_li">
            <a href="#gastenboek"><?php echo $lang['MENU_GASTENBOEK']; ?></a>
         </li>
         <li class="menu_li">
            <a href="#contact"><?php echo $lang['MENU_CONTACT']; ?></a>
         </li>
      </ul>
      <ul id="landen">
         <li id="land1"><a href="index.php?lang=en"><img src="images/uk_small.gif" height="30px" width="60px" alt="English"></a></li>
         <li id="land2"><a href="index.php?lang=nl"><img src="images/nl_small.gif" height="30px" width="60px"></a></li>
      </ul>


   </div>


   <div id="home" class="panel">
      <div class="contentpanel">
         <?php echo $lang['TEKST_HOME']; ?>
      </div>
   </div>
   <div id="kamp" class="panel">
      <div class="contentpanel">
         <h2>
            Newsletter
         </h2>
         <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
         </p>
         <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
         </p>
      </div>
   </div>
   <div id="organisatie" class="panel">
      <div class="contentpanel">
         <h2>
            Directions
         </h2>
         <p>
         <a href="index.php?lang=en">   Dit is een link naar de engelse site</a>      </p>
         <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
         </p>
         <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
         </p>
      </div>
   </div>
   <div id="thema" class="panel">
      <div class="contentpanel">
         <h2>
            VULLING
         </h2>
         <h2>
            VULLING
         </h2>
         <h2>
            VULLING
         </h2>
         <h2>
            VULLING
         </h2>
         <h2>
            VULLING
         </h2>
         <h2>
            VULLING
         </h2>
      </div>
   </div>
   <div id="inschrijven" class="panel">
      <div class="contentpanel">
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
      ?>          

      </div>
   </div>
   <div id="gastenboek" class="panel">
      <div class="contentpanel">
         <h2>
            Contact
         </h2>
         <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
         </p>
      </div>
   </div>
   <div id="contact" class="panel">
      <h2>
         Filler
      </h2>
      <p>
         Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </p>
   </div>
</div>
</body>
</html>
