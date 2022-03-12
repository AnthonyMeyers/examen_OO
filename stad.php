<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "./lib/autoload.php";

$htmlFunctions = $container->getHTMLFunctions();

$htmlFunctions->printHead();

$htmlFunctions->printJumbo();

$htmlFunctions->printNavbar();

$dbm = $container->getDBManager();

if ( ! is_numeric( $_GET['img_id']) ) die("Ongeldig argument " . $_GET['img_id'] . " opgegeven");

$data = $dbm->GetData( "select * from image where img_id=" . $_GET['img_id'] );

$htmlFunctions->MergeAllElements($data);

        ?>

