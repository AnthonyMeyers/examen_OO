<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

//Opening services

    $MessageService = $container->getMessageService();

    $security = $container->getSecurity();

    $htmlFunctions = $container->getHTMLFunctions();

    $htmlFunctions->printHead();

    $htmlFunctions->printJumbo( $title = "Login", $subtitle = "" );

    $post = new Post();

    $data = $post->postData();

    $htmlFunctions->MergeAllElements($data);

?>
