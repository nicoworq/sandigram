<?php

set_time_limit(0);
date_default_timezone_set('UTC');

require_once 'vendor/autoload.php';

/////// CONFIG ///////
$username = 'nico.sandia';
$password = 'pepepepe';


/////// MEDIA ////////
$photoFilename = 'C:/xampp/htdocs/sandigram/uploads/48113e197c5ca6473dd9e376aed9a199.jpg';
$captionText = "Probando el sandigraemeee. ";
//////////////////////

\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

$ig = new \InstagramAPI\Instagram();

try {
    $ig->login($username, $password);
} catch (\Exception $e) {
    echo 'Something went wrong: ' . $e->getMessage() . "\n";
    exit(0);
}
try {
    $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
    var_dump($ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $captionText]));
} catch (\Exception $e) {
    echo 'Something went wrong: ' . $e->getMessage() . "\n";
}
