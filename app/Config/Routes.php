<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->get('accueil', 'Home::index', ['filter' => 'auth']);
$routes->get('objectifs', 'ObjectifsController::index', ['filter' => 'auth']);
$routes->post('objectifs/submit', 'ObjectifsController::submit', ['filter' => 'auth']);
$routes->get('suggestions', 'SuggestionController::index', ['filter' => 'auth']);
$routes->get('regimes/details/(:num)', 'RegimeController::details/$1', ['filter' => 'auth']);
$routes->get('activites/details/(:num)', 'ActiviteController::details/$1', ['filter' => 'auth']);
$routes->get('code', 'CodeController::index', ['filter' => 'role:admin']);
$routes->post('code/store', 'CodeController::store', ['filter' => 'role:admin']);
$routes->post('code/use', 'CodeController::useCode', ['filter' => 'auth']);

$routes->post('login', 'LoginController::process');
$routes->post('save', 'LoginController::save');
$routes->post('authenticate', 'LoginController::authenticate');
