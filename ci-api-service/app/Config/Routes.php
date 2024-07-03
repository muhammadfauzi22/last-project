<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('tes', 'API\SubmissionController::tes');
$routes->group('api', ['namespace' => 'App\Controllers\API'], static function ($routes) {
    $routes->get('user/(:segment)', 'UserSubmissionController::getUser/$1');
    $routes->get('test', 'UserSubmissionController::getTest');
    $routes->post('login', 'UserSubmissionController::getLogin');
    $routes->get('logout', 'UserSubmissionController::getLogout');
    $routes->post('user/show', 'UserSubmissionController::getUsers');
    $routes->post('user/find', 'UserSubmissionController::findUser');
    $routes->post('register', 'UserSubmissionController::postRegister');
    $routes->post('deleteuser', 'UserSubmissionController::postDeleteUser');
    $routes->post('add-submission', 'UserSubmissionController::postAddSubmission');
    $routes->post('get-sess-submission', 'UserSubmissionController::getSessSubmission');
    $routes->post('get-submission', 'UserSubmissionController::getSubmission');
    $routes->post('get-submission-by-group', 'UserSubmissionController::getSubmissionByGroup');
    $routes->post('check-permission', 'UserSubmissionController::postCheckPermission');
    $routes->post('update-submission', 'UserSubmissionController::postUpdateSubmission');
    $routes->post('upload-submission', 'UserSubmissionController::postUploadSubmission');
    $routes->post('upload-status-submission', 'UserSubmissionController::postUploadStatusSubmission');
    $routes->post('change-submission', 'UserSubmissionController::postChangeSubmission');
    $routes->post('resubmit-submission', 'UserSubmissionController::postResubmitSubmission');
});
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'API\UserSubmissionController::index');
    $routes->get('submission_table', 'API\UserSubmissionController::submissionTable');
    $routes->get('submission_form', 'API\UserSubmissionController::submissionForm');
    $routes->get('submission_detail', 'API\UserSubmissionController::submissionDetail');
    $routes->get('user_management', 'API\UserSubmissionController::userManagement');
});
$routes->get('login', 'Home::login');

$routes->post('password-reset-request', 'API\PasswordResetController::requestReset');
$routes->get('password-reset/(:any)', 'API\PasswordResetController::resetPasswordForm/$1');
$routes->post('api/reset-password', 'API\PasswordResetController::resetPassword');
$routes->get('files/serve/(:any)', 'API\UserSubmissionController::serveFile/$1');
