<?php

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

