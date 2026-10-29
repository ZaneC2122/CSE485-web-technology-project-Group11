<?php
require_once __DIR__ . '/../app/config/config.php';
require_once APP_ROOT . '/app/libs/DbConnection.php';
require_once APP_ROOT . '/app/controllers/HomeController.php';
require_once APP_ROOT . '/app/controllers/StudentController.php';
require_once APP_ROOT . '/app/controllers/UserController.php';

session_start();

$controller = isset($_GET['controller']) && is_string($_GET['controller'])? $_GET['controller']:'home';
$action = isset($_GET['action']) && is_string($_GET['action'])? $_GET['action']: 'index';
$id = isset($_GET['id']) && is_string($_GET['id']) ? $_GET['id'] : null;

$homeController = new HomeController();
$studentController = new StudentController();
$userController = new UserController();

if ($controller === 'home') {
    if ($action === 'index') {
        $homeController->index();
    } else {
        echo 'Action chưa được cài đặt: ' . $action;
    }
} elseif ($controller === 'student') {
    if (empty($_SESSION['user'])) {
        header('Location: ' . DOMAIN . '?controller=user&action=login');
        exit;
    }

    if ($action === 'index') {
        $studentController->index();
    } elseif ($action === 'detail' && $id !== null) {
        $studentController->detail($id);
    } elseif ($action === 'delete') {
        $studentController->delete();
    } else {
        echo 'Action chưa được cài đặt: ' . $action;
    }
} elseif ($controller === 'user') {
    if ($action === 'login') {
        $userController->login();
    } elseif ($action === 'register') {
        $userController->register();
    } elseif ($action === 'logout') {
        $userController->logout();
    } else {
        echo 'Action chưa được cài đặt: ' . $action;
    }
} else {
    echo 'Controller chưa được cài đặt: ' . $controller;
}
