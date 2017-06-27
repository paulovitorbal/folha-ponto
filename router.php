<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->match('GET|POST', '/.*', function() { 
	require('index.php');
});
$router->match('GET|POST', '/vale-transporte/?.*', function() { 
	require('vale-transporte.php');
});

$router->run();