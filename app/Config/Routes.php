<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');

$routes->post('login', 'LoginController::process');
$routes->post('save', 'LoginController::save');
$routes->post('authenticate', 'LoginController::authenticate');

$routes->get('regime', 'RegimeController::index');
$routes->get('regime/create', 'RegimeController::create');
$routes->post('regime/store', 'RegimeController::store');
$routes->get('regime/show/(:num)', 'RegimeController::show/$1');
$routes->get('regime/edit/(:num)', 'RegimeController::edit/$1');
$routes->post('regime/update/(:num)', 'RegimeController::update/$1');
$routes->get('regime/delete/(:num)', 'RegimeController::delete/$1');

$routes->get('activite', 'ActiviteController::index');
$routes->get('activite/create', 'ActiviteController::create');
$routes->post('activite/store', 'ActiviteController::store');
$routes->get('activite/show/(:num)', 'ActiviteController::show/$1');
$routes->get('activite/edit/(:num)', 'ActiviteController::edit/$1');
$routes->post('activite/update/(:num)', 'ActiviteController::update/$1');
$routes->get('activite/delete/(:num)', 'ActiviteController::delete/$1');

$routes->get('paiement/achat-gold', 'PaiementController::achatGold');
$routes->post('paiement/traiter-achat', 'PaiementController::traiterAchat');
