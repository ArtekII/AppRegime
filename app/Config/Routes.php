<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->get('connexion', 'LoginController::login');
$routes->get('inscription', 'LoginController::register');
$routes->get('deconnexion', 'LoginController::logout', ['filter' => 'auth']);
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'role:admin']);
$routes->get('accueil', 'Home::index', ['filter' => 'auth']);
$routes->get('objectifs', 'ObjectifsController::index', ['filter' => 'auth']);
$routes->post('objectifs/submit', 'ObjectifsController::submit', ['filter' => 'auth']);
$routes->get('suggestions', 'SuggestionController::index', ['filter' => 'auth']);
$routes->get('suggestions/export-pdf', 'SuggestionController::exportPdf', ['filter' => 'auth']);
$routes->get('regimes/details/(:num)', 'RegimeController::details/$1', ['filter' => 'auth']);
$routes->post('regimes/acheter', 'RegimeController::acheter', ['filter' => 'auth']);
$routes->get('activites/details/(:num)', 'ActiviteController::details/$1', ['filter' => 'auth']);
$routes->get('code', 'CodeController::index', ['filter' => 'role:admin']);
$routes->post('code/store', 'CodeController::store', ['filter' => 'role:admin']);
$routes->post('code/update/(:num)', 'CodeController::update/$1', ['filter' => 'role:admin']);
$routes->get('code/delete/(:num)', 'CodeController::delete/$1', ['filter' => 'role:admin']);
$routes->get('code/use', 'CodeController::useForm', ['filter' => 'auth']);
$routes->post('code/use', 'CodeController::useCode', ['filter' => 'auth']);

$routes->post('save', 'LoginController::save');
$routes->post('authenticate', 'LoginController::authenticate');

$routes->get('regime', 'RegimeController::index', ['filter' => 'role:admin']);
$routes->get('regime/create', 'RegimeController::create', ['filter' => 'role:admin']);
$routes->post('regime/store', 'RegimeController::store', ['filter' => 'role:admin']);
$routes->get('regime/show/(:num)', 'RegimeController::show/$1', ['filter' => 'role:admin']);
$routes->get('regime/edit/(:num)', 'RegimeController::edit/$1', ['filter' => 'role:admin']);
$routes->post('regime/update/(:num)', 'RegimeController::update/$1', ['filter' => 'role:admin']);
$routes->get('regime/delete/(:num)', 'RegimeController::delete/$1', ['filter' => 'role:admin']);

$routes->get('activite', 'ActiviteController::index', ['filter' => 'role:admin']);
$routes->get('activite/create', 'ActiviteController::create', ['filter' => 'role:admin']);
$routes->post('activite/store', 'ActiviteController::store', ['filter' => 'role:admin']);
$routes->get('activite/show/(:num)', 'ActiviteController::show/$1', ['filter' => 'role:admin']);
$routes->get('activite/edit/(:num)', 'ActiviteController::edit/$1', ['filter' => 'role:admin']);
$routes->post('activite/update/(:num)', 'ActiviteController::update/$1', ['filter' => 'role:admin']);
$routes->get('activite/delete/(:num)', 'ActiviteController::delete/$1', ['filter' => 'role:admin']);

$routes->get('paiement/achat-gold', 'PaiementController::achatGold', ['filter' => 'auth']);
$routes->post('paiement/traiter-achat', 'PaiementController::traiterAchat', ['filter' => 'auth']);

$routes->get('parametres', 'ParametresController::index', ['filter' => 'role:admin']);
$routes->post('parametres/gold', 'ParametresController::updateGoldPrice', ['filter' => 'role:admin']);
$routes->post('parametres/prix-regime', 'ParametresController::storePrixRegime', ['filter' => 'role:admin']);
$routes->get('parametres/prix-regime/delete/(:num)', 'ParametresController::deletePrixRegime/$1', ['filter' => 'role:admin']);
$routes->post('parametres/effet-regime', 'ParametresController::storeEffetRegime', ['filter' => 'role:admin']);
$routes->get('parametres/effet-regime/delete/(:num)', 'ParametresController::deleteEffetRegime/$1', ['filter' => 'role:admin']);
$routes->post('parametres/objectif', 'ParametresController::storeObjectif', ['filter' => 'role:admin']);
$routes->get('parametres/objectif/delete/(:num)', 'ParametresController::deleteObjectif/$1', ['filter' => 'role:admin']);
