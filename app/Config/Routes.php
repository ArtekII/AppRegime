<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');

$routes->post('login', 'LoginController::process');
$routes->post('save', 'LoginController::save');
$routes->post('authenticate', 'LoginController::authenticate');