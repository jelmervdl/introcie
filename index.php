<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', true);
date_default_timezone_set('Europe/Amsterdam');

header('Cache-control: private'); // IE 6 FIX

include('classes/database.php');
include('classes/inschrijven.php');

/* Bepaal de taal */

if(isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
}
else if (!isset($lang) || !in_array($lang, array('nl', 'en'))) {
    $lang = 'nl';
}

// Hulpfunctie om vertalingen te includen uit de map languages
function include_translation($file, array $variables = array())
{
   // Vang alle output op
   ob_start();

   // Pak de variabelen die we willen meegeven aan het template uit
   extract($variables);

   // Laadt het template
   include sprintf('languages/%s/%s', $GLOBALS['lang'], $file);

   // Verzamel alle opgevangen output, en geef het terug als string
   return ob_get_clean();
}

/* Verbind met de database voor inschrijvingen (en gastenboek later) */
$data = new data();
$inschrijven = new inschrijven();

$data->connect();

$inschrijving = "";
if (!empty($_POST)){
    $inschrijving = $inschrijven->process($_POST);
}

// Vertaling van het menu
$lang_menu = include sprintf('languages/%s/menu.php', $lang);

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>How I met my Future Friends</title>

   <link rel="stylesheet" type="text/css" href="reset.css">
   <link rel="stylesheet" type="text/css" href="style.css">
   
   <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
   <link rel="icon" href="images/favicon.ico" type="image/x-icon">
   
   <script src="jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

   <!-- parallax layers -->

   <div class="parallax-panel">
      <img style="position:absolute; width: 400px; top: 40px; left: 60px" src="images/foto-1.jpg">
      <img style="position:absolute; width: 200px; top: 420px; left: 860px" src="images/foto-1.jpg">
   </div>

   <div class="parallax-panel">
      <img style="position:absolute; width: 400px; top: 460px; left: 270px" src="images/foto-1.jpg">
      <img style="position:absolute; width: 600px; top: 620px; left: 1260px" src="images/foto-1.jpg">
   </div>

   <div class="parallax-panel">
      <img style="position:absolute; width: 300px; top: -20px; left: 10px" src="images/foto-1.jpg">
      <img style="position:absolute; width: 800px; top: 780px; left: 460px" src="images/foto-1.jpg">
   </div>

   <!-- navigation -->
   
   <nav>
      <ul class="menu">
         <li><a href="#home"><?php echo $lang_menu['home'] ?></a></li>  
         <li><a href="#kamp"><?php echo $lang_menu['kamp'] ?></a></li>   
         <li><a href="#organisatie"><?php echo $lang_menu['organisatie'] ?></a></li>  
         <li><a href="#thema"><?php echo $lang_menu['thema'] ?></a></li>
         <li><a href="#inschrijven"><?php echo $lang_menu['inschrijven'] ?></a></li>
         <li><a href="#gastenboek"><?php echo $lang_menu['gastenboek'] ?></a></li>
         <li><a href="#contact"><?php echo $lang_menu['contact'] ?></a></li>
      </ul>
      <ul id="landen">
         <li><a href="index.php?lang=en"><img src="images/uk_small.gif" height="30" width="60" alt="English"></a></li>
         <li><a href="index.php?lang=nl"><img src="images/nl_small.gif" height="30" width="60" alt="Nederlands"></a></li>
      </ul>
   </nav>


   <div id="home" class="panel">
      <div class="contentpanel">
         <?php echo include_translation('home.php') ?>
      </div>
   </div>
   <div id="kamp" class="panel">
      <div class="contentpanel">
         <?php echo include_translation('kamp.php') ?>
      </div>
   </div>
   <div id="organisatie" class="panel">
      <div class="contentpanel">
         <?php echo include_translation('organisatie.php') ?>
      </div>
   </div>
   <div id="thema" class="panel">
      <div class="contentpanel">
         <?php echo include_translation('thema.php') ?>
      </div>
   </div>
   <div id="inschrijven" class="panel">
      <div class="contentpanel">
         <?php echo include_translation('inschrijven.php', compact('inschrijving')) ?>
      </div>
   </div>
   <div id="gastenboek" class="panel">
      <div class="contentpanel">
         <?php echo include_translation('gastenboek.php') ?>
      </div>
   </div>
   <div id="contact" class="panel">
      <div class="contentpanel">
         <?php echo include_translation('contact.php') ?>
      </div>
   </div>
</div>
<script>
   $("nav .menu a").bind("click",function(event){
      event.preventDefault();
      var target = $(this).attr("href");
      $("html, body").stop().animate({
         scrollLeft: $(target).offset().left,
         scrollTop: $(target).offset().top
      }, 600);
   });

   function resize()
   {
      $('.panel').css('width', window.innerWidth);

      $('body').css('width', window.innerWidth * $('.panel').length);

      $('body').css('background-size', (window.innerWidth * $('.panel').length) + 'px 100%');
   }

   var panels = $('.parallax-panel');

   window.onscroll = function()
   {
      panels.each(function(i) {
         $(this).css('transform', 'translateX(' + (-window.scrollX / (3 * (panels.length - i))) + 'px)');
      });
   }

   window.onresize = resize;

   resize();
   
</script>
</body>
</html>
