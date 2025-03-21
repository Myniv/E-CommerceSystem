<?php

use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Controllers\AuthController;
use App\Controllers\Home;
use App\Controllers\PesananController;
use App\Controllers\ProductController;
use App\Controllers\ProductImageController;
use App\Controllers\RoleController;
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

$routes->get('/health-check', function () {
    return view('v_health_check');
});

//Public routes
$routes->addRedirect('/home', '/');
$routes->get('/about-us', [Home::class, 'aboutUs']);
$routes->get('/dashboard', [Home::class, 'dashboard'], ['filter' => 'role:Administrator,Customer,Product Manager']);
$routes->get("product/catalog", [ProductController::class, 'productCatalog']);




//Admin routes
$routes->group('', ['filter' => 'role:Administrator'], function ($routes) {
    $routes->get('api/json', [Home::class, 'index']);
    $routes->get('api/json/product', [ApiController::class, 'getAllProductJSON']);
    $routes->get('api/json/product/(:num)', [ApiController::class, 'getProductJSONById/$1']);
    $routes->get('api/json/user', [ApiController::class, 'getAllUserJSON']);
    $routes->get('api/json/user/(:num)', [ApiController::class, 'getUserJSONById/$1']);

    $routes->get('admin/users', [UsersController::class, 'index']);
    $routes->get('admin/users/create', [UsersController::class, 'create']);
    $routes->post('admin/users/store', [UsersController::class, 'store']);
    $routes->get('admin/users/edit/(:num)', [UsersController::class, 'edit/$1']);
    $routes->put('admin/users/update/(:num)', [UsersController::class, 'update/$1']);
    $routes->delete('admin/users/delete/(:num)', [UsersController::class, 'delete/$1']);

    $routes->get('admin/customer', [UserEcommerceController::class, 'index']);
    $routes->get('admin/customer/detail/(:num)', [UserEcommerceController::class, 'detail']);
    $routes->get('admin/customer/profile-parser/(:num)', [UserEcommerceController::class, 'detailParser']);
    $routes->get('admin/customer/role/(:alphanum)', [UserEcommerceController::class, 'role']);
    $routes->get('admin/customer/settings/(:alpha)', [UserEcommerceController::class, 'settings']);
    $routes->match(['get', 'post'], 'admin/customer/create', [UserEcommerceController::class, 'create']);
    $routes->match(['get', 'put'], 'admin/customer/update/(:num)', [UserEcommerceController::class, 'update/$1']);
    $routes->delete('admin/customer/delete/(:num)', [UserEcommerceController::class, 'delete']);

    $routes->get('admin/roles', [RoleController::class, 'index']);
    $routes->match(['get', 'post'], 'admin/roles/create', [RoleController::class, 'create']);
    $routes->match(['get', 'post'], 'admin/roles/update/(:num)', [RoleController::class, 'update']);
    $routes->delete('admin/roles/delete/(:num)', [RoleController::class, 'delete']);
});

$routes->group('admin/user', ['filter' => 'role:Administrator'], function ($routes) {

});
$routes->group(
    'admin/users/',
    ['filter' => 'role:Administrator'],
    function ($routes) {

    }
);

//Admin || Product Manager routes
$routes->group('', ['filter' => 'role:Administrator,Product Manager'], function ($routes) {
    // $routes->resource("product", ['controller' => 'ProductController']);
    $routes->get('product', [ProductController::class, 'index']);
    $routes->get('product/new', [ProductController::class, 'new']);
    $routes->post('product', [ProductController::class, 'create']);
    $routes->get('product/(:num)', [ProductController::class, 'show/$1']);
    $routes->get('product/detail/(:num)', [ProductController::class, 'show/$1'], ['as' => 'product_details']);
    $routes->get('product/(:num)/edit', [ProductController::class, 'edit/$1']);
    $routes->put('product/(:num)', [ProductController::class, 'update/$1']);
    $routes->delete('product/(:num)', [ProductController::class, 'delete/$1']);
    $routes->match(['get', 'post'], 'product/(:num)/image', [ProductImageController::class, 'create/$1']);
    $routes->match(['get', 'put'], 'product/(:num)/image/edit', [ProductImageController::class, 'update/$1']);
});

//Customer ||Administrator routes
$routes->group('pesanan', ['filter' => 'role:Customer,Administrator'], function ($routes) {
    $routes->get('/', [PesananController::class, 'allPesanan']);
    $routes->get('create', [PesananController::class, 'goCreatePesanan']);
    $routes->post('add', [PesananController::class, 'createPesanan']);
    $routes->post('edit', [PesananController::class, 'editPesanan']);
    $routes->get('edit/(:num)', [PesananController::class, 'goEditPesanan/$1']);
    $routes->delete('delete/(:num)', [PesananController::class, 'deletePesanan/$1']);
    $routes->get('detail/(:num)', [PesananController::class, 'detailPesanan/$1']);
});
//Customer routes
$routes->group('', ['filter' => 'role:Customer'], function ($routes) {
    $routes->get('profile', [UserEcommerceController::class, 'profile']);
    $routes->match(['get', 'put'], 'profile/edit', [UserEcommerceController::class, 'editProfile']);
});

//Auth routes
$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    // Registrasi
    $routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('register', 'AuthController::attemptRegister');

    // Route lain seperti login, dll
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('login', 'AuthController::attemptLogin');

    //Forgot Password
    $routes->get('forgot-password', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('forgot-password', 'AuthController::attemptForgotPassword');

    //Reset Password
    $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('reset-password', 'AuthController::attemptResetPassword');

    $routes->get('unauthorized', [AuthController::class, 'unauthorized']);
});

