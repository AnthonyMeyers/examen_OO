<?php

require_once "lib/autoload.php";

$container->getHTMLFunctions()->printHead();
$container->getHTMLFunctions()->printJumbo( $title = "Leuke plekken in Europa", $subtitle = "Tips voor citytrips voor droge en natte vakantiegangers!" );
$container->getHTMLFunctions()->PrintNavbar();

$day = $container->getWeatherLoader()->getForecastNow()->getCurrentWeatherAsDataArray();
$container->getHTMLFunctions()->MergeAllElements($day);

$allWeather = $container->getWeatherLoader()->getWeatherForecastArray();
$container->getHTMLFunctions()->MergeAllElements($allWeather);



print "<br/>";
print "<br/>";
?>