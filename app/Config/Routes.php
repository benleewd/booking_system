<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages::index');
$routes->get('schedule', 'Schedule::index', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'schedule/(:any)', 'Schedule::core/$1');
$routes->match(['get', 'post'], 'groups/(:any)', 'Groups::core/$1');
$routes->match(['get', 'post'], 'resources/(:any)', 'Resources::core/$1');
$routes->get('logout', 'Users::logout', ['filter' => 'auth']);
$routes->match(['get','post'],'login', 'Users::index', ['filter' => 'noauth']);
$routes->match(['get','post'], 'addnewuser', 'Users::register', ['filter' => 'adminauth']);
$routes->match(['get', 'post'], 'addfacility', 'Facility::addFacility', ['filter' => 'adminauth']);
$routes->get('/admin/(:any)', 'Admin::showme/$1', ['filter' => 'adminauth']);
$routes->get('/(:any)', 'Pages::showme/$1', ['filter' => 'auth']);



/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
