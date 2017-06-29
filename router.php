<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();


$router->match('GET|POST', '/vale-transporte/?(\d{0,2})?/?(\d{4})?', function($mesInformado, $anoInformado) { 

	require('vale-transporte.php');
});

$router->match('GET|POST', '/?(\d{0,2})/?(\d{4})?', function($mesInformado, $anoInformado) { 
	require('index.php');
});

$router->run();