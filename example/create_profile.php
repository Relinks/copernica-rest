<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Replace with your API access token as provided by Copernica
$token = 'place-token-here';

// Replace with actual database number
$databaseNumber = 1234;

// Replace with your data, add custom fields if applicable
$data = ['email' => 'place@email-address.com'];

// Create API service class, pass token to gain access
$api = new \Copernica\Service\CopernicaRestApiService($token);

// Make API call to add new profile to the database with the number as specified above, and the data as specified above.
$result = $api->createProfile($databaseNumber, $data);

var_dump($result);
