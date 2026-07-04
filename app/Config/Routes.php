<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// products routes
$routes->get('products', 'ProductsController::index');
$routes->get('products/detail', 'ProductsController::detail');
$routes->post('products', 'ProductsController::create');
$routes->put('products', 'ProductsController::updateProduct');
$routes->delete('products', 'ProductsController::deleteProduct');