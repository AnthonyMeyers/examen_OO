<?php

require_once "lib/autoload.php";

//initiate necessary objects
$MessageService = $container->getMessageService();
$allCities = $container->getCityLoader()->createArrayCities();

$htmlFunctions = $container->getHTMLFunctions();
$htmlFunctions->printHead();
$htmlFunctions->printJumbo( $title = "Leuke plekken in Europa", $subtitle = "Tips voor citytrips voor vrolijke vakantiegangers!" );
$htmlFunctions->PrintNavbar();


//PrintMessages();

print '<div class="container">
        <div class="row">';

//toon messages als er zijn
   foreach ( $MessageService->ShowInfos() as $msg )
  {
       print '<div class="msgs">' . $msg . '</div>';
   }

    //get template

    $day = $container->getWeatherLoader()->getForecastNow(1);


   foreach($allCities as $key => $value)
   {

           $day = $container->getWeatherLoader()->getForecastNow($value["img_id"])->getCurrentWeatherAsDataArray();

           foreach($day[0] as $sub_key => $sub_value)
           {

               $allCities[$key][$sub_key] = $sub_value;

           }

   }

    $htmlFunctions->MergeAllElements($allCities);

   print '</div>
          </div>
          </body>
          </html>';
?>

