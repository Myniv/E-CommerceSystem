<?php

use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Controllers\Home;
use App\Controllers\PesananController;
use App\Controllers\ProductController;
use App\Controllers\UserEcommerceController;
use App\Controllers\UsersController;
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


$routes->group('api', ['filter' => 'role:Administrator'], function ($routes) {
    $routes->get('detail/(:num)', [ProductController::class, 'show/$1'], ['as' => 'product_details']);
    $routes->get('json', [Home::class, 'index']);
    $routes->get('json/product', [ApiController::class, 'getAllProductJSON']);
    $routes->get('json/product/(:num)', [ApiController::class, 'getProductJSONById/$1']);
    $routes->get('json/user', [ApiController::class, 'getAllUserJSON']);
    $routes->get('json/user/(:num)', [ApiController::class, 'getUserJSONById/$1']);
});

$routes->group('pesanan', ['filter' => 'role:user'], function ($routes) {
    $routes->get('/', [PesananController::class, 'allPesanan']);
    $routes->get('create', [PesananController::class, 'goCreatePesanan']);
    $routes->post('add', [PesananController::class, 'createPesanan']);
    $routes->post('edit', [PesananController::class, 'editPesanan']);
    $routes->get('edit/(:num)', [PesananController::class, 'goEditPesanan/$1']);
    $routes->delete('delete/(:num)', [PesananController::class, 'deletePesanan/$1']);
    $routes->get('detail/(:num)', [PesananController::class, 'detailPesanan/$1']);
});

$routes->group('admin', ['filter' => 'role:Administrator'], function ($routes) {
    // $routes->resource("product", ['controller' => 'ProductController']);
    $routes->get('product', [ProductController::class, 'index']);
    $routes->get('product/new', [ProductController::class, 'new']);
    $routes->post('product', [ProductController::class, 'create']);
    $routes->get('product/(:num)', [ProductController::class, 'show/$1']);
    $routes->get('product/(:num)/edit', [ProductController::class, 'edit/$1']);
    $routes->put('product/(:num)', [ProductController::class, 'update/$1']);
    $routes->delete('product/(:num)', [ProductController::class, 'delete/$1']);
});
$routes->get("product/catalog", [ProductController::class, 'productCatalog']);

$routes->group('admin/user', ['filter' => 'role:Administrator'], function ($routes) {
    $routes->get('/', [UserEcommerceController::class, 'index']);
    $routes->get('profile/(:num)', [UserEcommerceController::class, 'detail']);
    $routes->get('profile-parser/(:num)', [UserEcommerceController::class, 'detailParser']);
    $routes->get('role/(:alphanum)', [UserEcommerceController::class, 'role']);
    $routes->get('settings/(:alpha)', [UserEcommerceController::class, 'settings']);
    $routes->match(['get', 'post'], 'create', [UserEcommerceController::class, 'create']);
    $routes->match(['get', 'put'], 'update/(:num)', [UserEcommerceController::class, 'update/$1']);
    $routes->delete('delete/(:num)', [UserEcommerceController::class, 'delete']);
});

$routes->get('/admin/dashboard', [AdminController::class, 'dashboard'], ['filter' => 'role:Administrator', 'as' => 'user_dashboard']);
$routes->get('/admin/dashboard-parser', [AdminController::class, 'dashboardParser'], ['filter' => 'role:Administrator']);

$routes->get('/health-check', function () {
    return view('v_health_check');
});

// $routes->post('login', [Home::class, 'login']);
// $routes->get("unauthorized", [Home::class, "unauthorized"]);

$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    // Registrasi
    $routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('register', 'AuthController::attemptRegister');


    // Route lain seperti login, dll
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('login', 'AuthController::attemptLogin');
});

$routes->group(
    'admin/users',
    ['filter' => 'role:Administrator'],
    function ($routes) {
        $routes->get('/', [UsersController::class, 'index']);
        $routes->get('create', [UsersController::class, 'create']);
        $routes->post('store', [UsersController::class, 'store']);
        $routes->get('edit/(:num)', [UsersController::class, 'edit/$1']);
        $routes->put('update/(:num)', [UsersController::class, 'update/$1']);
        $routes->delete('delete/(:num)', [UsersController::class, 'delete/$1']);
    }
);