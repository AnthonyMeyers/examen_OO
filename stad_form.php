<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

$cityLoader = $container->getCityLoader();

$MessageService = $container->getMessageService();

$security = $container->getSecurity();

$formElements= $container->getFormElements();

$htmlFunctions = $container->getHTMLFunctions();

$htmlFunctions->printHead();

$htmlFunctions->printJumbo( $title = "Bewerk afbeelding", $subtitle = "" );

$htmlFunctions->PrintNavbar();

            if ( ! is_numeric( $_GET['img_id']) ) die("Ongeldig argument " . $_GET['img_id'] . " opgegeven");
            $city = $cityLoader->findOneById($_GET['img_id']);
            $arr = $city->getCityAsArray();
            $data[0]= $arr;

            //merge
            $htmlFunctions->MergeAllElements($data);

        ?>

