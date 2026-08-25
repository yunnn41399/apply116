<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */
$routes->get('/', 'HomeController::index');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::register');

//考生登入 - 登入、登出、驗證碼
$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::login');
$routes->get('/login/refresh-captcha', 'LoginController::refreshCaptcha');
$routes->get('/logout', 'LoginController::logout');

//考生登入 - 忘記密碼、重設密碼
$routes->get('/forgot-password', 'PasswordController::forgot');
$routes->post('/forgot-password/verify', 'PasswordController::verify');
$routes->get('/reset-password', 'PasswordController::reset');
$routes->post('/reset-password/update', 'PasswordController::update');

//網路報名系統 - 首頁、立即報名、選擇候選校系、報名狀態查詢
$routes->get('/apply', 'ApplyController::index');
$routes->get('/application', 'ApplicationController::index');
$routes->post('application/save', 'ApplicationController::save');
$routes->get('application/edit', 'ApplicationController::edit');
$routes->get('application/departments', 'ApplicationDepartmentController::index');
$routes->get('application-status', 'ApplicationStatusController::index');

//網路報名系統 - 我的校系清單
$routes->get('application/cart', 'ApplicationCartController::index');
$routes->post('application/cart/add/(:num)', 'ApplicationCartController::add/$1');
$routes->post('application/cart/remove/(:num)', 'ApplicationCartController::remove/$1');

//網路報名系統 - 選擇正式報名校系
$routes->get('application/selection', 'ApplicationSelectionController::index');
$routes->post('application/selection/toggle', 'ApplicationSelectionController::toggleSelection');
$routes->post('application/selection/save', 'ApplicationSelectionController::saveSelection');

//網路報名系統 - 確認報名
$routes->get('application/confirm', 'ApplicationConfirmController::index');
$routes->post('application/confirm/submit', 'ApplicationConfirmController::submit');

//驗證碼
$routes->get('/captcha', 'Captcha::index');
$routes->get('/register/refresh-captcha', 'Register::refreshCaptcha');

//NavBar - 校系分則查詢、網路報名系統、篩選結果查詢、審查資料上傳、網路登記志願、分發結果查詢
$routes->get('/department', 'DepartmentController::index');
$routes->get('application-info', 'ApplicationInfoController::index');
$routes->get('filter-result', 'SystemInfoController::filterResult');
$routes->get('review-upload', 'SystemInfoController::reviewUpload');
$routes->get('online-selection', 'SystemInfoController::onlineSelection');
$routes->get('distribution-result', 'SystemInfoController::distributionResult');

//SideBar - 招生資訊
$routes->get('admission/schedule', 'AdmissionController::schedule');
$routes->get('admission/brochure', 'AdmissionController::brochure');
$routes->get('admission/regulations', 'AdmissionController::regulations');
$routes->get('admission/statistics', 'AdmissionController::statistics');

//SideBar - 相關網站
$routes->get('related/organizations', 'RelatedController::organizations');
$routes->get('related/exams', 'RelatedController::exams');
$routes->get('related/other', 'RelatedController::other');

//SideBar - 聯絡資訊
$routes->get('contact', 'ContactController::index');