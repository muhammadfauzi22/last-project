<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('db-check', function () {
    try {
        $db = \Config\Database::connect();
        $db->initialize();
        echo "db connection success!";
    } catch (\Throwable $e) {
        echo "db connection failed" . $e->getMessage();
    }
});

$routes->get('login', 'Home::login');
$routes->post('password-reset-request', 'API\PasswordResetController::requestReset');
$routes->get('password-reset/(:any)', 'API\PasswordResetController::resetPasswordForm/$1');
$routes->post('api/reset-password', 'API\PasswordResetController::resetPassword');
service('auth')->routes($routes);
$routes->group('api', ['namespace' => 'App\Controllers\API'], static function ($routes) {
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
    $routes->post('loginForm', 'AuthController::loginForm');
    $routes->resource('user', ['controller' => 'AuthController']);
    $routes->get('user/(:segment)', 'UserSubmissionController::getUser/$1');
    $routes->get('test', 'AuthController::test');
    $routes->post('finduser', 'AuthController::finduser');
    $routes->post('registeruser', 'AuthController::registerUser');
    $routes->post('deleteuser', 'AuthController::deleteUser');
});
$routes->group('api/auth', ['namespace' => 'App\Controllers\API'], static function ($routes) {
    $routes->get('me', 'AuthController::me');
    $routes->get('me-group', 'AuthController::meGroup');
    $routes->get('logout', 'AuthController::logout');
    $routes->post('check-permission', 'AuthController::checkPermission');
    $routes->get('get-all-permission', 'AuthController::getAllPermission');
});
