<?php
// require_once __DIR__ . '/../app/config/config.php';
// require_once APP_ROOT . '/app/libs/DBConnection.php';

// session_start();

// $routes = [
//     'home'    => 'HomeController',
//     'auth'    => 'AuthController',
//     'student' => 'StudentController',
// ];

// $controller = $_GET['controller'] ?? 'home';
// $action     = $_GET['action'] ?? 'index';
// $id         = $_GET['id'] ?? null;

// if (!isset($routes[$controller])) {
//     http_response_code(404);
//     exit('404: controller khong ton tai');
// }

// require_once APP_ROOT . '/app/controllers/' . $routes[$controller] . '.php';
// $controllerObj = new $routes[$controller]();

// if (!method_exists($controllerObj, $action)) {
//     http_response_code(404);
//     exit('404: action chua duoc cai dat');
// }

// Hoan (dang nhap): them require app/libs/Auth.php o dau roi, truoc dong goi action
// thi chan: Auth::requireLogin(); voi auth/login va auth/register la public.
// $controllerObj->$action($id);

require_once('../app/config/config.php');
require_once APP_ROOT.'/app/libs/DbConnection.php';
require_once APP_ROOT.'/app/controllers/HomeController.php';
require_once APP_ROOT.'/app/controllers/StudentController.php';

$controller= isset($_GET['controller'])?$_GET['controller']:'home';
$action = isset($_GET['action'])?$_GET['action']:'index';
$id = isset($_GET['id'])?$_GET['id']:null;

$homeController = new HomeController();
$studentController = new StudentController();

if ($controller == 'home') {
    $homeController->index();
} else if ($controller == 'student') {
    if ($action == 'index') {
        $studentController->index();
    } else if ($action == 'detail') {
        $studentController->detail($id);
    } else {
        echo "Action chưa được cài đặt: " . $action;
    }
} else {
    echo "Controller chưa được cài đặt: " . $controller;
}
// else if (isset($_POST['btn_create'])) {$patientController->store();}
// else if ($controller == 'addPatient') {$patientController->add();}
// else if (isset($_POST['btn_update'])) {$patientController->update($id);}
// else if ($controller == 'editPatient') {$patientController->edit($id);}
// else if (isset($_POST['btn_delete'])) {$patientController->destroy($id);}
// else if ($controller == 'deletePatient') {$patientController->delete($id);}