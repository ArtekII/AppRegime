<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->get('objectifs', 'ObjectifsController::index');
$routes->post('objectifs/submit', 'ObjectifsController::submit');
$routes->get('suggestions', 'SuggestionController::index');
$routes->get('regimes/details/(:num)', 'RegimeController::details/$1');
$routes->get('activites/details/(:num)', 'ActiviteController::details/$1');

$routes->post('login', 'LoginController::process');
$routes->post('save', 'LoginController::save');
$routes->post('authenticate', 'LoginController::authenticate');
