<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once __DIR__  ."/configuration.php";
require_once __DIR__  ."/service/Container.php";
require_once __DIR__ . "/model/AbstractWeather.php";
require_once __DIR__ . "/model/BadWeather.php";
require_once __DIR__ . "/model/GoodWeather.php";
require_once __DIR__ . "/model/User.php";
require_once __DIR__ . "/model/Post.php";
require_once __DIR__ . "/model/City.php";
require_once __DIR__ ."/service/PublicAcces.php";
require_once __DIR__."/service/HTMLFunctions.php";
require_once __DIR__ . "/service/Logger.php";
require_once __DIR__ . "/service/DBManager.php";
require_once __DIR__ . "/service/Sanitization.php";
require_once __DIR__ . "/service/CheckLogin.php";
require_once __DIR__."/service/SaveCredentials.php";
require_once __DIR__ . "/service/FetchForecastInterface.php";
require_once __DIR__."/service/WeatherLoader.php";
require_once __DIR__."/service/JSONForecast.php";
require_once __DIR__."/service/PDOForecast.php";
require_once __DIR__ . "/service/CityLoader.php";
require_once __DIR__ . "/service/MessageService.php";
require_once __DIR__ . "/service/security.php";
require_once __DIR__ . "/service/FormElements.php";
require_once __DIR__ . "/service/Validation.php";
require_once __DIR__ . "/service/UserLoader.php";

session_start();

//Open service container
$container = new container($configuration);

    //Nakijken of de gebruiker werd doorverwezen
if(isset($_SERVER["HTTP_REFERER"])){
        //Als gebruiker komt van de loginpagina
    if(strpos($_SERVER["HTTP_REFERER"],"login.php")> 0)
    {

        $checkLogin = $container->getCheckLogin();
        $checkLogin->LoginCheck();
    }

    //Als de gebruiker komt van de register,profiel of stad_form pagina
    elseif(strpos($_SERVER["HTTP_REFERER"],"register.php")>0 ||
        strpos($_SERVER["HTTP_REFERER"],"profiel.php")>0 ||
        strpos($_SERVER["HTTP_REFERER"],"stad_form.php")>0)
    {

        $saveCredentials = $container ->getSaveCredentials();
        $saveCredentials->SaveFormData();

    }
}

    //Indien de gebruiker niet ingelogt is of dit geen publieke pagina is
    $publicAcces = $container->getPublicAccess();
    $publicAcces->checkAccess();






?>