<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */
$routes->get('/announcement', 'Announcement::index');
$routes->get('/announcement/(:num)', 'Announcement::detail/$1');
$routes->get('/admin/announcements', 'Announcement::adminIndex');
$routes->get('admin/announcement/create', 'Announcement::create');

$routes->get('/', 'HomeController::index');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::register');

$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::login');
$routes->get('/login/refresh-captcha', 'LoginController::refreshCaptcha');
$routes->get('/logout', 'LoginController::logout');

$routes->get('/forgot-password', 'PasswordController::forgot');
$routes->post('/forgot-password/verify', 'PasswordController::verify');
$routes->get('/reset-password', 'PasswordController::reset');
$routes->post('/reset-password/update', 'PasswordController::update');

$routes->get('/apply', 'ApplyController::index');
$routes->get('/department', 'DepartmentController::index');
$routes->get('/application', 'ApplicationController::index');
$routes->post('application/save', 'ApplicationController::save');
$routes->get('application/edit', 'ApplicationController::edit');
$routes->get('application/departments', 'ApplicationDepartmentController::index');
$routes->get('application-status', 'ApplicationStatusController::index');

$routes->get('application/cart', 'ApplicationCartController::index');
$routes->post('application/cart/add/(:num)', 'ApplicationCartController::add/$1');
$routes->post('application/cart/remove/(:num)', 'ApplicationCartController::remove/$1');

$routes->get('application/selection', 'ApplicationSelectionController::index');
$routes->post('application/selection/toggle', 'ApplicationSelectionController::toggleSelection');
$routes->post('application/selection/save', 'ApplicationSelectionController::saveSelection');

$routes->get('application/confirm', 'ApplicationConfirmController::index');
$routes->post('application/confirm/submit', 'ApplicationConfirmController::submit');

$routes->get('/captcha', 'Captcha::index');
$routes->get('/register/refresh-captcha', 'Register::refreshCaptcha');