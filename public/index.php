<?php
require_once __DIR__ . '/../app/config/config.php';
require_once APP_ROOT . '/app/libs/DbConnection.php';

session_start();

$routes = [
    'home' => [
        'controller' => 'HomeController',
        'actions' => ['index'],
    ],
    'user' => [
        'controller' => 'UserController',
        'actions' => ['login', 'register', 'logout'],
    ],
    'student' => [
        'controller' => 'StudentController',
        'actions' => ['index', 'detail', 'delete'],
    ],
];

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

if (!is_string($controller) || !isset($routes[$controller])) {
    http_response_code(404);
    exit('404: controller không tồn tại');
}

if (!is_string($action) || !in_array($action, $routes[$controller]['actions'], true)) {
    http_response_code(404);
    exit('404: action chưa được cài đặt');
}

if ($action === 'detail' && !is_string($id)) {
    http_response_code(404);
    exit('404: không tìm thấy sinh viên');
}

if ($controller === 'student' && empty($_SESSION['user'])) {
    header('Location: ' . DOMAIN . '?controller=user&action=login');
    exit;
}

require_once APP_ROOT . '/app/controllers/' . $routes[$controller]['controller'] . '.php';
$controllerClass = $routes[$controller]['controller'];
$controllerObject = new $controllerClass();

if ($action === 'detail') {
    $controllerObject->$action($id);
} else {
    $controllerObject->$action();
}
