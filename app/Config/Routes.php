<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'HomeController::index');


// 管理員登入／登出
$routes->get('admin/login', 'AdminAuth::login');
$routes->post('admin/login', 'AdminAuth::attemptLogin');
$routes->post('admin/logout', 'AdminAuth::logout');
$routes->get('admin/login/refresh-captcha', 'AdminAuth::refreshCaptcha');

// 管理員忘記密碼
$routes->get('admin/forgot-password', 'AdminForgotPassword::index');
$routes->post('admin/forgot-password', 'AdminForgotPassword::sendResetLink');
$routes->get('admin/forgot-password/refresh-captcha', 'AdminForgotPassword::refreshCaptcha');

// 管理員重設密碼
$routes->get('admin/reset-password', 'AdminResetPassword::index');
$routes->post('admin/reset-password', 'AdminResetPassword::update');
$routes->get('admin/reset-password/refresh-captcha', 'AdminResetPassword::refreshCaptcha');

// 第一次登入管理員帳號需更改密碼
$routes->get('admin/change-password', 'AdminPassword::changePassword'); 
$routes->post('admin/change-password', 'AdminPassword::updatePassword');
$routes->get('admin/change-password/refresh-captcha', 'AdminPassword::refreshCaptcha');

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

    // 我的帳號
    $routes->get('profile', 'AdminProfile::index');
    $routes->post('profile', 'AdminProfile::update');
    
    // 考生資料
    $routes->get('candidates', 'CandidateAdmin::index');
    $routes->get('candidates/(:num)', 'CandidateAdmin::detail/$1');

    // 報名資料
    $routes->get('applications', 'ApplicationAdmin::index');
    $routes->get('applications/(:num)', 'ApplicationAdmin::detail/$1');

    // 公告管理
    $routes->get('announcement', 'Announcement::adminIndex');
    
    $routes->get('announcement/create', 'Announcement::create');
    $routes->post('announcement/create', 'Announcement::create');

    $routes->get('announcement/edit/(:num)', 'Announcement::edit/$1');
    $routes->post('announcement/edit/(:num)', 'Announcement::edit/$1');

    $routes->post('announcement/delete/(:num)', 'Announcement::delete/$1');


    // 首頁管理
    $routes->get('homepage-pages', 'HomepagePageManagement::index');
    $routes->get('homepage-pages/edit/(:num)', 'HomepagePageManagement::edit/$1');
    $routes->post('homepage-pages/update/(:num)', 'HomepagePageManagement::update/$1');

    $routes->get('homepage-page-groups/edit/(:num)', 'HomepagePageGroupManagement::edit/$1');
    $routes->post('homepage-page-groups/update/(:num)', 'HomepagePageGroupManagement::update/$1');

    // 跑馬燈管理
    $routes->get('homepage-marquees', 'HomepageMarqueeManagement::index');
    $routes->get('homepage-marquees/create','HomepageMarqueeManagement::create');
    $routes->post('homepage-marquees/store', 'HomepageMarqueeManagement::store');
    $routes->get('homepage-marquee/edit/(:num)', 'HomepagePageManagement::marqueeEdit/$1');
    $routes->post('homepage-marquee/update/(:num)', 'HomepagePageManagement::marqueeUpdate/$1');
});


// 前台公告
$routes->get('/announcement', 'Announcement::index');
$routes->get('/announcement/(:num)', 'Announcement::detail/$1');
$routes->get('announcement/category/(:num)', 'Announcement::category/$1');

// 考生註冊
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::register');

// 考生登入 - 登入、登出、驗證碼
$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::login');

$routes->get('/login/refresh-captcha', 'LoginController::refreshCaptcha');

$routes->get('/logout', 'LoginController::logout');

// 考生登入 - 忘記密碼、重設密碼
$routes->get('/forgot-password', 'PasswordController::forgot');
$routes->post('/forgot-password/verify', 'PasswordController::verify');

$routes->get('/reset-password', 'PasswordController::reset');
$routes->post('/reset-password/update', 'PasswordController::update');

// 網路報名系統 - 首頁、立即報名、選擇候選校系、報名狀態查詢
$routes->get('/apply', 'ApplyController::index');
$routes->get('/application', 'ApplicationController::index');
$routes->post('/application/save', 'ApplicationController::save');

$routes->get('application/edit', 'ApplicationController::edit');
$routes->get('application/departments', 'ApplicationDepartmentController::index');
$routes->get('application-status', 'ApplicationStatusController::index');

// 網路報名系統 - 我的校系清單
$routes->get('application/cart', 'ApplicationCartController::index');
$routes->post('application/cart/add/(:num)', 'ApplicationCartController::add/$1');
$routes->post('application/cart/remove/(:num)', 'ApplicationCartController::remove/$1');

// 網路報名系統 - 選擇正式報名校系
$routes->get('application/selection', 'ApplicationSelectionController::index');
$routes->post('application/selection/toggle', 'ApplicationSelectionController::toggleSelection');
$routes->post('application/selection/save', 'ApplicationSelectionController::saveSelection');

// 網路報名系統 - 確認報名
$routes->get('application/confirm', 'ApplicationConfirmController::index');
$routes->post('application/confirm/submit', 'ApplicationConfirmController::submit');

// 驗證碼
$routes->get('/captcha', 'Captcha::index');
$routes->get('/register/refresh-captcha', 'Register::refreshCaptcha');

// NavBar - 校系分則查詢、網路報名系統、篩選結果查詢、審查資料上傳、網路登記志願、分發結果查詢
$routes->get('/department', 'DepartmentController::index');
$routes->get('application-info', 'ApplicationInfoController::index');
$routes->get('filter-result', 'SystemInfoController::filterResult');
$routes->get('review-upload', 'SystemInfoController::reviewUpload');
$routes->get('online-selection', 'SystemInfoController::onlineSelection');
$routes->get('distribution-result', 'SystemInfoController::distributionResult');

// SideBar - 招生資訊
$routes->get('admission/schedule', 'AdmissionController::schedule');
$routes->get('admission/brochure', 'AdmissionController::brochure');
$routes->get('admission/regulations', 'AdmissionController::regulations');
$routes->get('admission/statistics', 'AdmissionController::statistics');

// SideBar - 相關網站
$routes->get('related/organizations', 'RelatedController::organizations');
$routes->get('related/exams', 'RelatedController::exams');
$routes->get('related/other', 'RelatedController::other');

// SideBar - 聯絡資訊
$routes->get('contact', 'ContactController::index');
