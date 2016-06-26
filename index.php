<?php
include "initialise.php";
$address = "172.20.181.98";
function getSettings($pid,$address){
  $location = "/uploading/getTime.php?pid={$pid}";
  $url = "http://".$address.$location;
 // echo $url;
  $json = file_get_contents($url);
  $filename = "settings.json";
  $file_content = $json;
//  echo $file_content;
  $fh = fopen($filename,'w') or die("can't open file");
  fwrite($fh,$file_content);
  fclose($fh);
}
function pillDisSettings($pid,$address){
  $location = "/uploading/getMedicine.php?pid={$pid}";
  $url = "http://{$address}{$location}";
  $json = file_get_contents($url);
  $filename = "pillSettings.json";
  $file_content = $json;
  $fh = fopen($filename,'w') or die("can't open file");
  fwrite($fh,$file_content);
  fclose($fh);
}
if ($is_initialised){
  $download_string = "/uploading/getData.php?pid={$frame_id}";
  $url = "http://".$address.$download_string;
//  echo $url;
  $json = file_get_contents("$url");
  $obj = json_decode($json,true, 512, JSON_BIGINT_AS_STRING);
  //var_dump($obj);
  $file_count = count($obj["file"]);
  $slides = "";
  $download_address = "http://" . $address . "/uploading/upload/";
  //echo $file_count;
  for ($i=0; $i < $file_count ; $i++) {
    $img_id = $obj["file"][$i]['id'];
    //var_dump ($obj["file"][$i]['id']);
    //$link = "";
    $img_id -= 1;
    $link = $download_address . "{$img_id}".".png";
    $slides .= "<li>\n";
    $slides .= "<img src = {$link} class = 'img-responsive'>\n";
    $slides .= "</li>\n";
  }
  $download_string = "/uploading/getReminder.php?pid={$frame_id}";
  $url = "http://".$address.$download_string;
  //echo $url;
  $json = file_get_contents("$url");
  $obj = json_decode($json,true, 512, JSON_BIGINT_AS_STRING);
  //var_dump($obj);
  $file_count = count($obj["Reminder"]);
  $reminders = "";
  //echo $file_count;
  for ($i=0; $i < $file_count ; $i++) {
    $note = $obj["Reminder"][$i]["note"];
    //var_dump ($obj["Reminder"][$i]['note']);
    //$link = "";
    $reminders .= "<div class='divider'></div>\n";
    $reminders .= "<div class='section'>\n";
    $reminders .= "<p>$note</p>\n";
    $reminders .= "</div>\n";
    //var_dump($reminders);
  }
  getSettings($frame_id,$address);
  pillDisSettings($frame_id,$address);
  $settings = file_get_contents('settings.json');
  $settings_obj = json_decode($settings,true,512,JSON_BIGINT_AS_STRING);
  $interval = $settings_obj['timeset'];
} else{
  header("location:login.php");
}
 //echo $reminders;

//echo $slides;
?>
<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body class="grey lighten-3">
      <div class="navbar-fixed ">
        <nav>
          <div class="nav-wrapper indigo">
          <div class="row">
            <div class="col">
                <a href="index.html" class="brand-logo">Logo</a>
            </div>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li><a href="sass.html">Sass</a></li>
              <li><a href="badges.html">Components</a></li>
              <li><a href="collapsible.html">Javascript</a></li>
              <li><a href="mobile.html">Mobile</a></li>
            </ul>
            <ul class="side-nav" id="mobile-demo">
              <li><a href="sass.html">Sass</a></li>
              <li><a href="badges.html">Components</a></li>
              <li><a href="collapsible.html">Javascript</a></li>
              <li><a href="mobile.html">Mobile</a></li>
            </ul>
          </div>
          </div>
        </nav>
      </div>
      <div class="row">
        <div class="col s12 m9 l9">
          <div class="card">
            <div class="card-image ">
              <div class="slider">
                <ul class="slides">
                  <?php
                  echo $slides;
                   ?>
                </ul>
              </div>
            </div>
            <div class="card-content">
              <span class="card-title activator grey-text text-darken-4">Album Name<i class="material-icons right">more_vert</i></span>
            </div>
            <div class="card-reveal">
              <span class="card-title grey-text text-darken-4">Album name<i class="material-icons right">close</i></span>
              <p>Album message</p>
            </div>
          </div>
        </div>
        <div class="col s12 m3 l3">
            <div class="col s12">
              <div class="card hoverable">
                <div class="card-image">
                  <a href="http://www.accuweather.com/en/us/new-york-ny/10007/weather-forecast/349727" class="aw-widget-legal">
                  <!--
                  By accessing and/or using this code snippet, you agree to AccuWeather’s terms and conditions (in English) which can be found at http://www.accuweather.com/en/free-weather-widgets/terms and AccuWeather’s Privacy Statement (in English) which can be found at http://www.accuweather.com/en/privacy.
                  -->
                  </a><div id="awcc1466239712357" class="aw-widget-current"  data-locationkey="" data-unit="c" data-language="en-us" data-useip="true" data-uid="awcc1466239712357"></div><script type="text/javascript" src="http://oap.accuweather.com/launch.js"></script>
                </div>
              </div>
            </div>
            <div class="col s12">
              <div class="card-panel hoverable">
                <h4 class="">Reminders</h4>
                <?php echo $reminders; ?>
                <!-- <div class="section">
                  <p>Stuff</p>
                </div>
                <div class="divider"></div>
                <div class="section">
                  <p>Stuff</p>
                </div> -->
            </div>

        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col s12 m9 l8">
          </div>
        </div>
      </div>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {
          $(".button-collapse").sideNav();
          $('.slider').slider({
            full_width: true,
            indicators:false,
            height:600,
          });
        })
      </script>

    </body>
  </html>
