<?php

require_once "lib/autoload.php";

$container->getHTMLFunctions()->printHead();
$container->getHTMLFunctions()->printJumbo( $title = "Leuke plekken in Europa", $subtitle = "Tips voor citytrips voor droge en natte vakantiegangers!" );
$container->getHTMLFunctions()->PrintNavbar();
$city = $container->getDBManager()->GetData('select img_title from image where img_id like "'.$_GET["id"].'"');


$day = $container->getWeatherLoader()->getForecastJSONToday();
$data = $day->getDayWeatherAsDataArray();

$container->getHTMLFunctions()->MergeAllElements($data);

$data = $container->getPDOForecast()->PDOFetchFakeWeather();
print "<br/>";
print "<br/>";
?>