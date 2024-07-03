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
$routes->group('api', ['namespace' => 'App\Controllers\API'], static function ($routes) {
    $routes->post('add-submission', 'SubmissionController::addSubmission');
    $routes->post('get-sess-submission', 'SubmissionController::getSessSubmission');
    $routes->post('get-last-sess-submission', 'SubmissionController::getLastSessSubmission');
    $routes->post('get-submission', 'SubmissionController::getSubmission');
    $routes->post('get-submission-by-group', 'SubmissionController::getSubmissionByGroup');
    $routes->post('update-submission-by-group', 'SubmissionController::postSubmissionStatusByGroup');
    $routes->post('upload-submission', 'SubmissionController::uploadSubmission');
    $routes->post('change-submission', 'SubmissionController::changeSubmission');
    $routes->post('resubmit-submission', 'SubmissionController::resubmitSubmission');
});
