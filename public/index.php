<?php
require_once __DIR__ . '/../app/config/config.php';
require_once APP_ROOT . '/app/libs/DBConnection.php';

session_start();

$routes = [
    'home'    => 'HomeController',
    'auth'    => 'AuthController',
    'student' => 'StudentController',
];

$controller = $_GET['controller'] ?? 'home';
$action     = $_GET['action'] ?? 'index';
$id         = $_GET['id'] ?? null;

if (!isset($routes[$controller])) {
    http_response_code(404);
    exit('404: controller khong ton tai');
}

require_once APP_ROOT . '/app/controllers/' . $routes[$controller] . '.php';
$controllerObj = new $routes[$controller]();

if (!method_exists($controllerObj, $action)) {
    http_response_code(404);
    exit('404: action chua duoc cai dat');
}

// Hoan (dang nhap): them require app/libs/Auth.php o dau roi, truoc dong goi action
// thi chan: Auth::requireLogin(); voi auth/login va auth/register la public.
$controllerObj->$action($id);
