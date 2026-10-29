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
        $csrfToken = $this->getCsrfToken();

        // Xử lý khi người dùng gửi form đăng nhập
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submittedEmail = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $submittedToken = $_POST['csrf_token'] ?? '';
            $email = is_string($submittedEmail) ? trim($submittedEmail) : '';

            // Token xác nhận form đăng nhập được gửi từ phiên hiện tại.
            if (!is_string($submittedToken) || !hash_equals($csrfToken, $submittedToken)) {
                $error = 'Phiên đăng nhập không hợp lệ. Vui lòng tải lại trang và thử lại.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !is_string($password) || $password === '') {
                $error = 'Vui lòng nhập email hợp lệ và mật khẩu.';
            } else {
                $userService = new UserService();
                $user = $userService->loginUser($email, $password);

                // Nếu đăng nhập thành công, lưu thông tin người dùng vào session và chuyển hướng
                if ($user) {
                    // Tạo session mới để ngăn chặn session fixation
                    session_regenerate_id(true);
                    $_SESSION['user'] = [
                        'id' => $user['id_user'],
                        'name' => $user['ho_ten'],
                        'email' => $user['email'],
                    ];
                    // Làm mới token sau khi đăng nhập để dùng cho các form cần xác nhận.
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                    header('Location: ' . DOMAIN . '?controller=student&action=index', true, 303);
                    exit;
                }
                // Nếu đăng nhập thất bại, hiển thị thông báo lỗi
                $error = 'Email hoặc mật khẩu không chính xác.';
            }
        }

        include APP_ROOT . '/app/views/user/login.php';
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            exit('Phương thức không được hỗ trợ.');
        }

        $submittedToken = $_POST['csrf_token'] ?? '';
        $csrfToken = $this->getCsrfToken();
        // Chỉ đăng xuất khi form gửi token hợp lệ của phiên hiện tại.
        if (!is_string($submittedToken) || !hash_equals($csrfToken, $submittedToken)) {
            http_response_code(400);
            exit('Phiên làm việc không hợp lệ. Vui lòng tải lại trang và thử lại.');
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

    private function getCsrfToken()
    {
        // Tạo token ngẫu nhiên nếu phiên chưa có, hoặc dùng lại token đang có.
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }
}
