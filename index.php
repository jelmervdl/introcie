<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', true);

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

function inschrijving_geopend()
{
   return true;
}

function inschrijving_gesloten()
{
   return date('j') >= 28 && date('n') >= 8;
}

/* Verbind met de database voor inschrijvingen (en gastenboek later) */
$data = new data();
$inschrijven = new inschrijven();

$data->connect();

$inschrijving = "";

if (!empty($_POST) && inschrijving_geopend() && !inschrijving_gesloten())
   $inschrijving = $inschrijven->process($_POST);

// Vertaling van het menu
$lang_menu = include sprintf('languages/%s/menu.php', $lang);

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
   <title>How I met my Future Friends</title>

   <link rel="stylesheet" type="text/css" href="reset.css">
   <link rel="stylesheet" type="text/css" href="style.css">
   
   <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
   <link rel="icon" href="images/favicon.ico" type="image/x-icon">
   
   <script src="jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>

   <?php if (date('md') == '0705'): ?>
   <!-- Comic Sans-day! -->
   <style>
      body {
         font-family: Comic Sans MS;
      }
   </style>
   <?php endif ?>
</head>
<body>

   <!-- parallax layers -->

   <div class="parallax-panel">
      <img class="asset-head" style="left:500px" src="images/sherlock.png">
   </div>

   <div class="parallax-panel">
      <img class="asset-head" style="left:900px" src="images/dexter.png">
   </div>

   <div class="parallax-panel">
      <img class="asset-head" style="left:-200px" src="images/house.png">
      <img class="asset-head" style="left:1400px" src="images/stark.png">
   </div>

   <div class="parallax-panel">
      <img class="asset-head" style="left:2200px; bottom: -100px;" src="images/bender.png">
   </div>

   <div class="parallax-panel">
      <img class="asset-head" style="left:300px" src="images/bean.png">
      <img class="asset-head" style="height: 40%; left:2800px" src="images/tennant.png">
   </div>

   <div class="parallax-panel">
      <img class="asset-flying" style="left: 1500px" src="images/jetsons.png">
   </div>

   <!-- navigation -->
   
   <nav>
      <ul class="menu">
         <li><a href="#home"><?php echo $lang_menu['home'] ?></a></li>  
         <li><a href="#kamp"><?php echo $lang_menu['kamp'] ?></a></li>   
         <li><a href="#organisatie"><?php echo $lang_menu['organisatie'] ?></a></li>  
         <li><a href="#thema"><?php echo $lang_menu['thema'] ?></a></li>
         <li><a href="#paklijst"><?php echo $lang_menu['paklijst'] ?></a></li>
         <li><a href="#inschrijven"><?php echo $lang_menu['inschrijven'] ?></a></li>
         <li><a href="#gastenboek"><?php echo $lang_menu['gastenboek'] ?></a></li>
         <li><a href="#contact"><?php echo $lang_menu['contact'] ?></a></li>

         <?php if ($lang == 'nl'): ?>
         <li class="land"><a href="index.php?lang=en"><img src="images/uk_small.gif" height="30" width="60" alt="English"></a></li>
         <?php else: ?>
         <li class="land"><a href="index.php?lang=nl"><img src="images/nl_small.gif" height="30" width="60" alt="Nederlands"></a></li>
         <?php endif ?>
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
   <div id="paklijst" class="panel">
      <div class="contentpanel">
         <?php echo include_translation('paklijst.php') ?>
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
   var panels = $('.panel');

   var parallax_panels = $('.parallax-panel');

   /* jQuery plugins om gemakkelijk form elementen aan en uit te zetten */

   jQuery.fn.disable = function() {
      return this.each(function() {
         this.disable = true;
      });
   };

   jQuery.fn.enable = function() {
      return this.each(function() {
         this.disable = false;
      });
   };

   /* Vang links in navigatie af zodat ze scrollen ipv springen */

   $('a[href^=#]').bind("click",function(event){
      event.preventDefault();
      var target = $(this).attr("href");
      
      // Soort-van het normale gedrag van de browser history behouden
      if (window.history.pushState)
         window.history.pushState({target: target}, "", target);

      $("html, body").stop().animate({
         scrollLeft: $(target).offset().left,
         scrollTop: $(target).offset().top
      }, 600);
   });

   // Vang link naar voorwaarden op om deze speciaal te behandelen.
   $('a[href=#voorwaarden]').click(function(event) {
      event.preventDefault();

      var target = $('#voorwaarden')

      target.show();

      $("html, body").stop().animate({
         scrollTop: target.offset().top - 100
      }, 600);
   });

   // maar verberg de voorwaarden standaard (met JS, zodat niet-js ze nog wel ziet)
   $('#voorwaarden').hide();
   
   function update_panel_width()
   {
      panels.css('width', window.innerWidth);

      $('body').css('width', window.innerWidth * panels.length);

      // $('body').css('background-size', (window.innerWidth * panels.length) + 'px 100%');
   }

   function update_inschrijfkosten()
   {
      var is_sjaars = $('#inschrijven select[name=deelnemer]').val() == 'sjaars';
      $('#inschrijven .kosten').text(is_sjaars ? '30,00' : '35,00');
   }

   // Inschrijfkosten zijn afhankelijk van wie zich inschrijft
   $('#inschrijven select[name=deelnemer]').change(update_inschrijfkosten);

   // (ook onload, immers, het kan zijn dat we een fout opgestuurd formulier krijgen)
   update_inschrijfkosten();

   // Positioneer de panelen ten opzichte van de scroll-afstand
   function update_parallax()
   {
      parallax_panels.each(function(i) {
         $(this).css('transform', 'translateX(' + (-window.scrollX / (2 * (panels.length - i))) + 'px)');
      });
   }

   // Voeg de class 'visible' toe aan de link die verwijst naar het paneel dat het meest zichtbaar is
   function update_scrollspy()
   {
      panels.each(function() {
         var is_frontmost = Math.abs(this.offsetLeft - window.scrollX) < window.innerWidth / 2;
         $('nav .menu a[href=#' + this.id + ']').toggleClass('visible', is_frontmost);
      });
   }

   window.onscroll = function() {
      // Geen reden om dit uit te voeren wanneer we klein zijn.
      if (window.innerWidth < 800)
         return;

      update_parallax();
      
      update_scrollspy();
      
      $(document.body).toggleClass('scrolled', window.scrollY > 8);
   };

   window.onresize = function() {
      update_panel_width();
   };

   update_panel_width();
   
   update_scrollspy();

   $('#gastenboek form').submit(function(e) {
      e.preventDefault();
      var form = this;

      // Disable form elements
      $(form).find('input,button').disable();

      // fill in the captcha
      $(form).find('input[name=captcha]').val('groen');

      // Submit the data to the gastenboek page.
      $.post('gastenboek.php?last_bericht_id=' + get_last_bericht_id(), $(this).serialize(), function(html) {
         // Prepend message to message list
         $('.gastenboek').prepend(html);
         
         // Re-enable form elements
         $(form).find('input,button').enable();

         // and clear data
         $(form).find('textarea').val('');
      });
   });

   function get_last_bericht_id()
   {
      try {
         return $('.gastenboek-entry').first().get(0).id.match(/bericht-(\d+)/)[1];
      } catch (e) {
         return 0;
      }
   }

   function get_oldest_bericht_id()
   {
      try {
         return $('.gastenboek-entry').last().get(0).id.match(/bericht-(\d+)/)[1];
      } catch (e) {
         return 0;
      }
   }

   function load_gastenboek()
   {
      $('.gastenboek-next-page-button').disable();

      $.get('gastenboek.php?last_bericht_id=' + get_oldest_bericht_id(), function(html) {
         $('.gastenboek').append(html);

         $('.gastenboek-next-page-button').enable();
      });
   }

   $('.gastenboek-next-page-button').click(load_gastenboek);

   load_gastenboek();

   $('.gastenboek-captcha').hide();

</script>
</body>
</html>