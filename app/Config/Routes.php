<?php

use App\Controllers\AdminController;
use App\Controllers\ApiController;
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


$routes->group('api', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('detail/(:num)', [ProductController::class, 'show/$1'], ['as' => 'product_details']);
    $routes->get('json', [Home::class, 'index']);
    $routes->get('json/product', [ApiController::class, 'getAllProductJSON']);
    $routes->get('json/product/(:num)', [ApiController::class, 'getProductJSONById/$1']);
    $routes->get('json/user', [ApiController::class, 'getAllUserJSON']);
    $routes->get('json/user/(:num)', [ApiController::class, 'getUserJSONById/$1']);
});

$routes->group('pesanan', ['filter' => 'auth:user'], function ($routes) {
    $routes->get('/', [PesananController::class, 'allPesanan']);
    $routes->get('create', [PesananController::class, 'goCreatePesanan']);
    $routes->post('add', [PesananController::class, 'createPesanan']);
    $routes->post('edit', [PesananController::class, 'editPesanan']);
    $routes->get('edit/(:num)', [PesananController::class, 'goEditPesanan/$1']);
    $routes->delete('delete/(:num)', [PesananController::class, 'deletePesanan/$1']);
    $routes->get('detail/(:num)', [PesananController::class, 'detailPesanan/$1']);
});

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    // $routes->resource("product", ['controller' => 'ProductController']);
    $routes->get('product', [ProductController::class, 'index']); // GET - List all products
    $routes->get('product/new', [ProductController::class, 'new']); // GET - Show form to create a new product
    $routes->post('product', [ProductController::class, 'create']); // POST - Store a new product
    $routes->get('product/(:num)', [ProductController::class, 'show/$1']); // GET - Show a single product
    $routes->get('product/(:num)/edit', [ProductController::class, 'edit/$1']); // GET - Show edit form for a product
    $routes->put('product/(:num)', [ProductController::class, 'update/$1']); // PUT - Update a product
    // $routes->patch('product/(:num)', [ProductController::class, 'update/$1']); // PATCH - Partial update
    $routes->delete('product/(:num)', [ProductController::class, 'delete/$1']); // DELETE - Delete a product
});
$routes->get("product/catalog", [ProductController::class, "allProductParser"]);

$routes->group('admin/user', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('/', [UserController::class, 'index']);
    $routes->get('profile/(:num)', [UserController::class, 'detail']);
    $routes->get('profile-parser/(:num)', [UserController::class, 'detailParser']);
    $routes->get('role/(:alphanum)', [UserController::class, 'role']);
    $routes->get('settings/(:alpha)', [UserController::class, 'settings']);
    $routes->match(['get', 'post'], 'create', [UserController::class, 'create']);
    $routes->match(['get', 'put'], 'update/(:num)', [UserController::class, 'update/$1']);
    $routes->delete('delete/(:num)', [UserController::class, 'delete']);
});

$routes->get('/admin/dashboard', [AdminController::class, 'dashboard'], ['filter' => 'auth:admin']);
$routes->get('/admin/dashboard-parser', [AdminController::class, 'dashboardParser'], ['filter' => 'auth:admin', 'as' => 'user_dashboard']);

$routes->get('/health-check', function () {
    return view('v_health_check');
});

// $routes->resource('admin', [
//     'controller' => 'Home',
//     'only' => ['show']
// ]);

$routes->post('login', [Home::class, 'login']);
$routes->get("unauthorized", [Home::class, "unauthorized"]);