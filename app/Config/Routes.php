<?php

use App\Controllers\ProductController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/product', [ProductController::class, 'allProduct']);
$routes->get('/product/detail/(:num)', [ProductController::class, 'detailProduct']);
$routes->get('/product/create', [ProductController::class, 'goCreateProduct']);
$routes->post('/product/add', [ProductController::class, 'createProduct']);
$routes->get('/product/edit/(:num)', [ProductController::class, 'goEditProduct']);
$routes->post('/product/edit', [ProductController::class, 'editProduct']);
$routes->delete('/product/delete/(:num)', [ProductController::class, 'deleteProduct']);

