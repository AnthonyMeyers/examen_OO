<?php

require_once "lib/autoload.php";

$container->getHTMLFunctions()->printHead();
$container->getHTMLFunctions()->printJumbo( $title = "Leuke plekken in Europa", $subtitle = "Tips voor citytrips voor droge en natte vakantiegangers!" );
$container->getHTMLFunctions()->PrintNavbar();
$day = $container->getWeatherLoader()->getForecastToday();

$data = $day->getDayWeatherAsDataArray();

$container->getHTMLFunctions()->MergeAllElements($data);

print "<br/>";
print "<br/>";
?>