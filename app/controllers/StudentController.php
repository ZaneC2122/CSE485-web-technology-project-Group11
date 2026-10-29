<?php
require_once APP_ROOT . '/app/services/StudentService.php';

class StudentController
{
    public function index()
    {
        if (isset($_GET['q'])) {
            $q = is_string($_GET['q']) ? trim($_GET['q']) : '';
        } else {
            $q = '';
        }

        $studentService = new StudentService();
        $students = $studentService->getAll($q);
        $total = $studentService->countAll();
        $csrfToken = $this->getCsrfToken();
        $flash = $_SESSION['flash'] ?? '';
        unset($_SESSION['flash']);

        // Gan q vao moi duong link de tu khoa tim khong bi mat khi bam vao nut
        if ($q != '') {
            $qParam = '&q=' . urlencode($q);
        } else {
            $qParam = '';
        }

        include APP_ROOT . '/app/views/student/index.php';
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            exit('Phương thức không được hỗ trợ.');
        }

        $id = $_POST['id'] ?? '';
        if (!is_string($id) || $id === '') {
            http_response_code(404);
            exit('Không tìm thấy sinh viên.');
        }

        $csrfToken = $this->getCsrfToken();
        $submittedToken = $_POST['csrf_token'] ?? '';
        // Chỉ xử lý xóa nếu token gửi từ form khớp token trong phiên hiện tại.
        if (
            !is_string($submittedToken)
            || !hash_equals($csrfToken, $submittedToken)
        ) {
            http_response_code(400);
            exit('Phiên làm việc không hợp lệ. Vui lòng tải lại trang và thử lại.');
        }

        $studentService = new StudentService();
        if (!$studentService->deleteStudent($id)) {
            http_response_code(404);
            exit('Không tìm thấy sinh viên.');
        }

        $_SESSION['flash'] = 'Đã xóa hồ sơ sinh viên ' . $id . '.';
        $submittedQuery = $_POST['q'] ?? '';
        $redirect = DOMAIN . '?controller=student&action=index';
        if (is_string($submittedQuery) && $submittedQuery !== '') {
            $redirect .= '&q=' . rawurlencode($submittedQuery);
        }
        header('Location: ' . $redirect, true, 303);
        exit;
    }

    private function getCsrfToken()
    {
        // Tạo token ngẫu nhiên một lần cho phiên để gắn vào form và kiểm tra khi gửi.
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public function detail($id)
    {
        $studentService = new StudentService();
        $student = $studentService->getStudentById($id);

        if (!$student) {
            echo "Không tìm thấy sinh viên.";
            return;
        }

        include APP_ROOT . '/app/views/student/detail.php';
    }

    public function edit($id)
    {
        $student = (new StudentService())->getStudentById($id);
        if (!$student) {
            http_response_code(404);
            exit('Không tìm thấy sinh viên.');
        }

        $csrfToken = $this->getCsrfToken();
        $q = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
        include APP_ROOT . '/app/views/student/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Không hỗ trợ phương thức này.');
        }

        $csrfToken = $this->getCsrfToken();
        $submittedToken = $_POST['csrf_token'] ?? '';
        if (!is_string($submittedToken) || !hash_equals($csrfToken, $submittedToken)) {
            http_response_code(400);
            exit('Phiên làm việc không hợp lệ.');
        }

        $fields = [
            'ho_ten', 'ngay_sinh', 'gioi_tinh', 'ten_lop', 'nganh', 'khoa',
            'trang_thai', 'cccd', 'ngay_cap_cccd', 'noi_cap_cccd', 'dan_toc',
            'quoc_tich', 'dia_chi_thuong_tru', 'noi_o_hien_tai', 'ngay_nhap_hoc',
            'nguoi_lien_he', 'sdt_nguoi_lien_he', 'ghi_chu'
        ];

        $data = [];
        foreach ($fields as $field) {
            $value = $_POST[$field] ?? '';
            $value = is_string($value) ? trim($value) : '';
            $data[$field] = $value !== '' ? $value : null;
        }

        if ($data['ho_ten'] === null) {
            http_response_code(422);
            exit('Họ và tên không được để trống.');
        }

        $updated = (new StudentService())->updateStudent($id, $data);
        if (!$updated) {
            http_response_code(404);
            exit('Không tìm thấy sinh viên.');
        }

        $_SESSION['flash'] = 'Đã cập nhật hồ sơ sinh viên ' . $id . '.';
        $submittedQuery = $_POST['q'] ?? '';
        $redirect = DOMAIN . '?controller=student&action=index';
        if (is_string($submittedQuery) && $submittedQuery !== '') {
            $redirect .= '&q=' . rawurlencode($submittedQuery);
        }
        header('Location: ' . $redirect, true, 303);
        exit;
    }
}
