<?php

use App\Controllers\Home;
use App\Controllers\PesananController;
use App\Controllers\ProductController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);
$routes->addRedirect('/home', '/');
$routes->get('/about-us', [Home::class, 'aboutUs']);

//Product Route
$routes->get('/product', [ProductController::class, 'allProduct']);
$routes->get('/product/detail/(:num)', [ProductController::class, 'detailProduct']);
$routes->get('/product/create', [ProductController::class, 'goCreateProduct']);
$routes->post('/product/add', [ProductController::class, 'createProduct']);
$routes->get('/product/edit/(:num)', [ProductController::class, 'goEditProduct']);
$routes->post('/product/edit', [ProductController::class, 'editProduct']);
$routes->delete('/product/delete/(:num)', [ProductController::class, 'deleteProduct']);

//Pesanan Route
$routes->get('/pesanan', [PesananController::class, 'allPesanan']);
$routes->get('/pesanan/create', [PesananController::class, 'goCreatePesanan']);
$routes->post('/pesanan/add', [PesananController::class, 'createPesanan']);
$routes->post('/pesanan/edit', [PesananController::class, 'editPesanan']);
$routes->get('/pesanan/edit/(:num)', [PesananController::class, 'goEditPesanan']);
$routes->delete('/pesanan/delete/(:num)', [PesananController::class, 'deletePesanan']);
$routes->get('/pesanan/detail/(:num)', [PesananController::class, 'detailPesanan']);

