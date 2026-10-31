<?php
require_once APP_ROOT . '/app/services/UserService.php';

class UserController
{
    public function login()
    {
        // Nếu người dùng đã đăng nhập, chuyển hướng đến trang chính
        if (!empty($_SESSION['user'])) {
            header('Location: ' . DOMAIN . '?controller=student&action=index');
            exit;
        }

        // Khởi tạo biến để lưu trữ dữ liệu và lỗi
        $email = '';
        $error = '';
        $success = $_SESSION['registration_success'] ?? '';
        unset($_SESSION['registration_success']);

        // Xử lý khi người dùng gửi form đăng nhập
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submittedEmail = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = is_string($submittedEmail) ? trim($submittedEmail) : '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !is_string($password) || $password === '') {
                $error = 'Vui lòng nhập email hợp lệ và mật khẩu.';
            } else {
                $userService = new UserService();
                $user = $userService->loginUser($email, $password);

                if ($user) {
                    session_regenerate_id(true);
                    $_SESSION['user'] = [
                        'id' => $user['id_user'],
                        'name' => $user['ho_ten'],
                        'email' => $user['email'],
                    ];
                    header('Location: ' . DOMAIN . '?controller=student&action=index', true, 303);
                    exit;
                }

                $error = 'Email hoặc mật khẩu không chính xác.';
            }
        }


        include APP_ROOT . '/app/views/user/login.php';
    }

    public function register()
    {
        if (!empty($_SESSION['user'])) {
            header('Location: ' . DOMAIN . '?controller=student&action=index');
            exit;
        }

        $name = '';
        $email = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submittedName = $_POST['ho_ten'] ?? '';
            $submittedEmail = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $name = is_string($submittedName) ? trim($submittedName) : '';
            $email = is_string($submittedEmail) ? trim($submittedEmail) : '';

            if (
                $name === ''
                || !preg_match('/^.{1,100}$/us', $name)
                || !filter_var($email, FILTER_VALIDATE_EMAIL)
                || strlen($email) > 100
                || !is_string($password)
                || !preg_match('/^.{8,}$/us', $password)
                || strlen($password) > 72
                || !is_string($confirmPassword)
                || $password !== $confirmPassword
            ) {
                $error = 'Vui lòng kiểm tra họ tên, email và mật khẩu (mật khẩu từ 8 ký tự, tối đa 72 byte, xác nhận phải trùng khớp).';
            } else {
                $userService = new UserService();

                try {
                    $user = $userService->registerUser($name, $email, $password);
                } catch (PDOException $exception) {
                    if ($exception->getCode() !== '23000') {
                        throw $exception;
                    }

                    $user = false;
                }

                if ($user) {
                    $_SESSION['registration_success'] = 'Đăng ký thành công. Vui lòng đăng nhập bằng tài khoản vừa tạo.';
                    header('Location: ' . DOMAIN . '?controller=user&action=login', true, 303);
                    exit;
                }

                $error = 'Email này đã được sử dụng. Vui lòng đăng nhập hoặc dùng email khác.';
            }
        }

        include APP_ROOT . '/app/views/user/register.php';
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            exit('Phương thức không được hỗ trợ.');
        }

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $cookie = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httponly']
            );
        }
        session_destroy();

        header('Location: ' . DOMAIN . '?controller=user&action=login', true, 303);
        exit;
    }
}
