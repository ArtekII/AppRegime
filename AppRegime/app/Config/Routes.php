<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');

$routes->post('login', 'LoginController::process');
$routes->post('save', 'LoginController::save');
$routes->post('authenticate', 'LoginController::authenticate');

$routes->get('code', 'CodeController::index');
$routes->post('code/store', 'CodeController::store');
$routes->post('code/use', 'CodeController::use_code');

// mainPage
$routes->get('mainPage', 'LoginController::mainPage');
