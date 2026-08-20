<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');


// 管理員登入／登出
$routes->get('admin/login', 'AdminAuth::login');
$routes->post('admin/login', 'AdminAuth::attemptLogin');
$routes->post('admin/logout', 'AdminAuth::logout');

// 管理員管理
$routes->get(
    '/admin/admins', 'AdminManagement::index',
    [
        'filter' => [
            'adminAuth',
            'adminRole:super_admin',
        ],
    ]
);

$routes->get(
    '/admin/admins/create', 'AdminManagement::create',
    [
        'filter' => [
            'adminAuth',
            'adminRole:super_admin',
        ],
    ]
);

$routes->post(
    '/admin/admins/create', 'AdminManagement::create',
    [
        'filter' => [
            'adminAuth',
            'adminRole:super_admin',
        ],
    ]
);

// 編輯管理員
$routes->get(
    '/admin/admins/edit/(:num)', 'AdminManagement::edit/$1',
    [
        'filter' => [
            'adminAuth',
            'adminRole:super_admin',
        ],
    ]
);

$routes->post(
    '/admin/admins/edit/(:num)', 'AdminManagement::edit/$1',
    [
        'filter' => [
            'adminAuth',
            'adminRole:super_admin',
        ],
    ]
);

// 管理員操作紀錄
$routes->get('admin/logs', 'AdminLog::index',
    [
        'filter' => [
            'adminAuth',
            'adminRole:super_admin',
        ],
    ]
);

// 後臺管理功能，必須登入管理員帳號才能進入頁面
$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {

    // 後臺首頁
    $routes->get('/', 'Admin::index');


    // 考生資料
    $routes->get('candidates', 'CandidateAdmin::index');
    $routes->get('candidates/(:num)', 'CandidateAdmin::detail/$1');


    // 報名資料
    $routes->get('applications', 'ApplicationAdmin::index');
    $routes->get('application/(:num)', 'ApplicationAdmin::detail/$1');


    // 公告管理
    $routes->get('announcement', 'Announcement::adminIndex');
    
    $routes->get('announcement/create', 'Announcement::create');
    $routes->post('announcement/create', 'Announcement::create');

    $routes->get('announcement/edit/(:num)', 'Announcement::edit/$1');
    $routes->post('announcement/edit/(:num)', 'Announcement::edit/$1');

    $routes->post('announcement/delete/(:num)', 'Announcement::delete/$1');
});


// 前台公告
$routes->get('/announcement', 'Announcement::index');
$routes->get('/announcement/(:num)', 'Announcement::detail/$1');


// 考生註冊
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::register');


// 考生登入
$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::login');

$routes->get('/login/refresh-captcha', 'LoginController::refreshCaptcha');

$routes->get('/logout', 'LoginController::logout');


// 忘記密碼
$routes->get('/forgot-password', 'PasswordController::forgot');
$routes->post('/forgot-password/verify', 'PasswordController::verify');

$routes->get('/reset-password', 'PasswordController::reset');
$routes->post('/reset-password/update', 'PasswordController::update');


// 報名系統
$routes->get('/apply', 'ApplyController::index');

$routes->get('/department', 'DepartmentController::index');

$routes->get('/application', 'ApplicationController::index');
$routes->post('/application/save', 'ApplicationController::save');


// 驗證碼
$routes->get('/captcha', 'Captcha::index');
$routes->get('/register/refresh-captcha', 'Register::refreshCaptcha');