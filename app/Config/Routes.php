<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function () {
    return redirect()->route('login');
});

// Otentikasi
$routes->group('auth', function (RouteCollection $routes) {
    $routes->get('login', 'AuthenticationController::login', ['as' => 'login']);
    $routes->post('login', 'AuthenticationController::attemptLogin', ['as' => 'attemptLogin']);
    $routes->get('register', 'AuthenticationController::register', ['as' => 'register']);
    $routes->post('register', 'AuthenticationController::attemptRegister', ['as' => 'attemptRegister']);
    $routes->get('logout', 'AuthenticationController::logout', ['as' => 'logout']);
});

// HRD
$routes->group('hrd', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('dashboard', 'DashboardController::dashboard_hrd', ['as' => 'hrd.dashboard']);

    // Group Profile Matching
    $routes->group('profile-matching', function (RouteCollection $routes) {
        $routes->get('/', 'ProfileMatchingController::index', ['as' => 'hrd.profile-matching.index']);
    });

    // Group Promethee
    $routes->group('promethee', function (RouteCollection $routes) {
        $routes->get('/', 'PrometheeController::index', ['as' => 'hrd.promethee.index']);
        $routes->get('detail/(:any)', 'PrometheeController::detail/$1', ['as' => 'hrd.promethee.detail']);
        $routes->post('save-ranking', 'PrometheeController::save_ranking', ['as' => 'hrd.promethee.save_ranking']);
    });

    // Group Batch
    $routes->group('batch', function (RouteCollection $routes) {
        $routes->get('/', 'BatchController::index', ['as' => 'hrd.batch.index']);
        $routes->post('/', 'BatchController::store', ['as' => 'hrd.batch.store']);
        $routes->get('delete/(:num)', 'BatchController::delete/$1', ['as' => 'hrd.batch.delete']);
        $routes->post('update', 'BatchController::update', ['as' => 'hrd.batch.update']);
    });

    // Group Candidate
    $routes->group('candidate', function (RouteCollection $routes) {
        $routes->get('/', 'CandidateController::index', ['as' => 'hrd.candidate.index']);
        $routes->post('/', 'CandidateController::store', ['as' => 'hrd.candidate.store']);
        $routes->get('delete/(:num)', 'CandidateController::delete/$1', ['as' => 'hrd.candidate.delete']);
        $routes->post('update', 'CandidateController::update', ['as' => 'hrd.candidate.update']);
    });

    // Group Parameter
    $routes->group('parameter', function (RouteCollection $routes) {
        $routes->get('/', 'ParameterController::index', ['as' => 'hrd.parameter.index']);
        $routes->post('/', 'ParameterController::store', ['as' => 'hrd.parameter.store']);
        $routes->get('delete/(:num)', 'ParameterController::delete/$1', ['as' => 'hrd.parameter.delete']);
        $routes->post('update', 'ParameterController::update', ['as' => 'hrd.parameter.update']);
    });

    // Group Sub Parameter
    $routes->group('sub-parameter', function (RouteCollection $routes) {
        $routes->get('/', 'SubParameterController::index', ['as' => 'hrd.sub-parameter.index']);
        $routes->post('/', 'SubParameterController::store', ['as' => 'hrd.sub-parameter.store']);
        $routes->get('delete/(:num)', 'SubParameterController::delete/$1', ['as' => 'hrd.sub-parameter.delete']);
        $routes->post('update', 'SubParameterController::update', ['as' => 'hrd.sub-parameter.update']);
    });

    // Group Sub Parameter
    $routes->group('grade-sub-parameter', function (RouteCollection $routes) {
        $routes->post('/', 'GradeSubParameterController::store', ['as' => 'hrd.grade-sub-parameter.store']);
        $routes->get('delete/(:num)', 'GradeSubParameterController::delete/$1', ['as' => 'hrd.grade-sub-parameter.delete']);
        $routes->post('update', 'GradeSubParameterController::update', ['as' => 'hrd.grade-sub-parameter.update']);
    });

    // Group Detail Profile Matching
    $routes->group('detail-profile-matching', function (RouteCollection $routes) {
        $routes->get('(:any)', 'DetailProfileMatchingController::index/$1', ['as' => 'hrd.detail-profile-matching.index']);
        $routes->post('update', 'DetailProfileMatchingController::update', ['as' => 'hrd.detail-profile-matching.update']);
    });

    // Group Preference
    $routes->group('preference', function (RouteCollection $routes) {
        $routes->get('/', 'PreferenceController::index', ['as' => 'hrd.preference.index']);
        $routes->post('/', 'PreferenceController::store', ['as' => 'hrd.preference.store']);
        $routes->get('delete/(:num)', 'PreferenceController::delete/$1', ['as' => 'hrd.preference.delete']);
        $routes->post('update', 'PreferenceController::update', ['as' => 'hrd.preference.update']);
    });

    // Group Ranking
    $routes->group('ranking', function (RouteCollection $routes) {
        $routes->get('/', 'RankingController::index', ['as' => 'hrd.ranking.index']);
        $routes->get('detail/(:any)', 'RankingController::detail/$1', ['as' => 'hrd.ranking.detail']);
    });
});

// Route Candidate
$routes->group('candidate', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('dashboard', 'DashboardController::dashboard_candidate', ['as' => 'candidate.dashboard']);
    // Group Form
    $routes->group('form', function (RouteCollection $routes) {
        $routes->get('(:any)', 'FormController::index/$1', ['as' => 'candidate.form.index']);
        $routes->post('/', 'FormController::store', ['as' => 'candidate.form.store']);
        $routes->post('update', 'FormController::update', ['as' => 'candidate.form.update']);
    });
    // Group Batch
    $routes->group('batch', function (RouteCollection $routes) {
        $routes->get('/', 'BatchController::index', ['as' => 'candidate.batch.index']);
    });
});
