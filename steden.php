<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

//initiate necessary objects
$MessageService = $container->getMessageService();
$cities = $container->getCityLoader();

$allCities = $cities->createArrayCities();

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
    $htmlFunctions->MergeAllElements($allCities);

   print '</div>
          </div>
          </body>
          </html>';
?>
