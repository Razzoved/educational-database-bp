<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Material');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->group('/', function($routes) {
    $routes->add('', 'Material::index');
    $routes->add('best', 'MaterialTopRated::index');
    $routes->add('popular', 'MaterialMostViewed::index');

    // SINGLE material
    $routes->get('(:num)', 'Material::get/$1');
    $routes->post('(:num)', 'Material::rate/$1', ['filter' => 'ajax']);

    // AUTHENTICATION
    $routes->add('login', 'Authentication::index');
    $routes->post('login', 'Authentication::login');
    $routes->add('reset/(:segment)', 'Authentication::reset/$1');
    $routes->add('reset', 'Authentication::resetSubmit');
    $routes->add('logout', 'Authentication::logout');
});

$routes->group('admin', function($routes) {
    $routes->addRedirect('', 'admin/dashboard');
    $routes->add('dashboard', 'Admin\Dashboard::index');
    $routes->get('config', 'Admin\Config::index');

    $routes->add('migration', 'Admin\Migration::index');
    $routes->add('rollback', 'Admin\Migration::back');

    $routes->group('material', function($routes) {
        $routes->get('', 'Admin\Material::index');
        $routes->post('', 'Admin\MaterialEditor::save');
        $routes->get('new', 'Admin\MaterialEditor::index');
        $routes->get('(:num)', 'Admin\MaterialEditor::get/$1');
    });

    $routes->get('tag', 'Admin\Property::index');
    $routes->get('file', 'Admin\Resource::index');
    $routes->get('user', 'Admin\User::index');

    $routes->group('ajax', ['filter' => 'ajax'], function($routes) {

        $routes->group('config', function($routes) {
            $routes->post('value', 'Admin\Config::save');
            $routes->post('image', 'Admin\Config::resetImage');
        });

        $routes->group('material', function($routes) {
            $routes->get('all', 'Admin\Material::getAvailable');
            $routes->delete('(:num)', 'Admin\MaterialEditor::delete/$1');
        });

        $routes->group('tag', function($routes) {
            $routes->post('', 'Admin\Property::save');
            $routes->get('all', 'Admin\Property::getAvailable');
            $routes->get('(:num)', 'Admin\Property::get/$1');
            $routes->delete('(:num)', 'Admin\Property::delete/$1');
        });

        $routes->group('file', function($routes) {
            $routes->post('', 'Admin\Resource::assign');
            $routes->post('upload', 'Admin\Resource::upload');
            $routes->delete('(:num)', 'Admin\Resource::delete/$1');
            $routes->delete('unused', 'Admin\Resource::deleteUnusedAll');
            $routes->delete('(:any)', 'Admin\Resource::deleteUnused/$1');
        });

        $routes->group('user', function($routes) {
            $routes->post('', 'Admin\User::save');
            $routes->get('(:num)', 'Admin\User::get/$1');
            $routes->delete('(:num)', 'Admin\User::delete/$1');
        });
    });
});

/*
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
