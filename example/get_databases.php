<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Replace with your API access token as provided by Copernica
$token = 'place-token-here';

// Create API service class, pass token to gain access
$api = new \Copernica\Service\CopernicaRestApiService($token);

// Make API call
$result = $api->getDatabases();

var_dump($result);
