<?php

require '../vendor/autoload.php';

$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);


$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->getBody()->write("Hello, " . $args['name']);
});


$current_uri = '/users/';

$app->any($current_uri, function($request, $response, $args){

$apiRequest =  new \App\API();
$apiResponse = $apiRequest->ask($request);
	$response->getBody()->write($apiResponse['result']);
    return $response->withStatus($apiResponse['code']) ;
});


$app->run();
?>