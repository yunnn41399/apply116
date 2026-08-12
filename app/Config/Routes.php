<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::register');

$routes->get('/captcha', 'Captcha::index');
$routes->get('/register/refresh-captcha', 'Register::refreshCaptcha');
