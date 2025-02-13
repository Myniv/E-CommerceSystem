<?php

use App\Controllers\Home;
use App\Controllers\PesananController;
use App\Controllers\ProductController;
use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->environment('development', static function ($routes) {
    $routes->get('/', [Home::class, 'development']);
});
$routes->environment('production', static function ($routes) {
    $routes->get('/', [Home::class, 'production']);
});

$routes->addRedirect('/home', '/');
$routes->get('/about-us', [Home::class, 'aboutUs']);

$routes->group('api/product',['filter' => 'auth:user'], function ($routes) {
    $routes->get('/', [ProductController::class, 'allProduct']);
    $routes->get('detail/(:num)', [ProductController::class, 'detailProduct/$1'], ['as' => 'product_details']);
    $routes->get('create', [ProductController::class, 'goCreateProduct']);
    $routes->post('add', [ProductController::class, 'createProduct']);
    $routes->get('edit/(:num)', [ProductController::class, 'goEditProduct/$1']);
    $routes->post('edit', [ProductController::class, 'editProduct']);
    $routes->delete('delete/(:num)', [ProductController::class, 'deleteProduct/$1']);
});

$routes->group('api/pesanan',['filter' => 'auth:user'], function ($routes) {
    $routes->get('/', [PesananController::class, 'allPesanan']);
    $routes->get('create', [PesananController::class, 'goCreatePesanan']);
    $routes->post('add', [PesananController::class, 'createPesanan']);
    $routes->post('edit', [PesananController::class, 'editPesanan']);
    $routes->get('edit/(:num)', [PesananController::class, 'goEditPesanan/$1']);
    $routes->delete('delete/(:num)', [PesananController::class, 'deletePesanan/$1']);
    $routes->get('detail/(:num)', [PesananController::class, 'detailPesanan/$1']);
});

$routes->group('admin/user', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('/', [UserController::class, 'index']);
    $routes->get('profile/(:num)', [UserController::class, 'detail']);
    $routes->get('role/(:alphanum)', [UserController::class, 'role']);
    $routes->get('settings/(:alpha)', [UserController::class, 'settings']);
    $routes->match(['get', 'post'], 'create', [UserController::class, 'create']);
    $routes->match(['get', 'put'], 'update/(:num)', [UserController::class, 'update/$1']);
    $routes->delete('delete/(:num)', [UserController::class, 'delete']);
});

$routes->get('/admin/dashboard', [Home::class, 'dashboard'], ['filter' => 'auth:admin', 'as' => 'user_dashboard']);

$routes->get('/health-check', function () {
    return view('v_health_check');
});

$routes->resource('admin', [
    'controller' => 'Home', // Menggunakan controller tertentu secara explisit
    'only' => ['show'] // Hanya menggunakan method tertentu
]);

$routes->post('login', [Home::class, 'login']);
$routes->get("unauthorized", [Home::class, "unauthorized"]);