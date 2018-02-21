<?php

set_time_limit(0);
date_default_timezone_set('UTC');

require 'vendor/autoload.php';

/////// CONFIG ///////
$username = 'nico.sandia';
$password = 'pepepepe';
$debug = true;
$truncatedDebug = false;


\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

try {
    $ig->login($username, $password);
} catch (\Exception $e) {
    echo 'Something went wrong: ' . $e->getMessage() . "\n";
    exit(0);
}

try {

    $userId = $ig->people->getUserIdForName('juliannnmarley');
    
    $recipients = [
        'users' => array($userId) // must be an [array] of valid UserPK IDs
    ];

    $text = "Rasti, tenes un liyo?";
    
    
    $ig->direct->sendText($recipients, $text);
    
    
} catch (\Exception $e) {
    echo 'Something went wrong: ' . $e->getMessage() . "\n";
}
