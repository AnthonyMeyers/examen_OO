<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );


require_once "lib/autoload.php";

//Opening services
$MessageService = $container->getMessageService();

$security = $container->getSecurity();

$htmlFunctions = $container->getHTMLFunctions();

$htmlFunctions->printHead();

$htmlFunctions->printJumbo( $title = "Profiel", $subtitle = "" );

        //get data
        if ( isset($_SESSION["user"]) )
        {
            $data[0]=$_SESSION["user"]->getAllUserData();
        }
        else $data = [ 0 => [ "usr_voornaam" => "", "usr_naam" => "", "usr_email" => "", "usr_telefoon" => "" ]];

        //merge

        $htmlFunctions->MergeAllElements($data);

        ?>

