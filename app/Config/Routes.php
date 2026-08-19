<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');


// 管理員登入
$routes->get('admin/login', 'AdminAuth::login');
$routes->post('admin/login', 'AdminAuth::attemptLogin');
$routes->post('admin/logout', 'AdminAuth::logout');

$routes->get('/admin', 'Admin::index');

$routes->get('/admin/candidates', 'CandidateAdmin::index');
$routes->get('/admin/candidates/(:num)', 'CandidateAdmin::detail/$1');

$routes->get('/admin/applications', 'CandidateApplicationAdmin::index');

$routes->get('/admin/applications', 'ApplicationAdmin::index');
$routes->get('/admin/application/(:num)', 'ApplicationAdmin::detail/$1');

// 前台公告
$routes->get('/announcement', 'Announcement::index');
$routes->get('/announcement/(:num)', 'Announcement::detail/$1');


// 後臺公告管理
$routes->get(
    '/admin/announcement',
    'Announcement::adminIndex',
    ['filter' => 'adminAuth']
);

$routes->get(
    'admin/announcement/create',
    'Announcement::create',
    ['filter' => 'adminAuth']
);

$routes->post(
    'admin/announcement/create',
    'Announcement::create',
    ['filter' => 'adminAuth']
);

$routes->get(
    '/admin/announcement/edit/(:num)',
    'Announcement::edit/$1',
    ['filter' => 'adminAuth']
);

$routes->post(
    '/admin/announcement/edit/(:num)',
    'Announcement::edit/$1',
    ['filter' => 'adminAuth']
);

$routes->post(
    '/admin/announcement/delete/(:num)',
    'Announcement::delete/$1',
    ['filter' => 'adminAuth']
);


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