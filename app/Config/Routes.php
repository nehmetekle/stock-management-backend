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


// categories routes
$routes->get('categories', 'CategoriesController::index');
$routes->get('categories/detail', 'CategoriesController::detail');
$routes->post('categories', 'CategoriesController::create');
$routes->put('categories', 'CategoriesController::updateCategory');
$routes->delete('categories', 'CategoriesController::deleteCategory');