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

        if ($q != '') {
            $qParam = '&q=' . urlencode($q);
        } else {
            $qParam = '';
        }

        include APP_ROOT . '/app/views/student/index.php';
    }

    public function add()
    {
        $q = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
        $this->renderAddForm($q);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            exit('Phương thức không được hỗ trợ.');
        }

        $fields = [
            'ma_sv', 'ho_ten', 'ngay_sinh', 'gioi_tinh',
            'ten_lop', 'nganh', 'khoa', 'trang_thai'
        ];

        $data = [];
        foreach ($fields as $field) {
            $value = $_POST[$field] ?? '';
            $data[$field] = is_string($value) ? trim($value) : '';
        }

        $query = isset($_POST['q']) && is_string($_POST['q'])
            ? trim($_POST['q'])
            : '';

        $error = '';
        foreach ($fields as $field) {
            if ($data[$field] === '') {
                $error = 'Vui lòng điền đầy đủ các trường thông tin.';
                break;
            }
        }

        if (
            $error === ''
            && (
                strlen($data['ma_sv']) > 10
                || !preg_match('/^.{1,100}$/us', $data['ho_ten'])
                || !preg_match('/^.{1,50}$/us', $data['ten_lop'])
                || !preg_match('/^.{1,100}$/us', $data['nganh'])
                || !preg_match('/^.{1,100}$/us', $data['khoa'])
            )
        ) {
            $error = 'Mã sinh viên hoặc thông tin nhập vào vượt quá độ dài cho phép.';
        }

        if ($error === '' && !in_array($data['gioi_tinh'], ['Nam', 'Nữ'], true)) {
            $error = 'Vui lòng chọn giới tính hợp lệ.';
        }

        if (
            $error === ''
            && !in_array(
                $data['trang_thai'],
                ['Đang học', 'Bảo lưu', 'Thôi học'],
                true
            )
        ) {
            $error = 'Vui lòng chọn trạng thái hợp lệ.';
        }

        if ($error === '') {
            $date = DateTime::createFromFormat('!Y-m-d', $data['ngay_sinh']);
            $dateErrors = DateTime::getLastErrors();

            if (
                !$date
                || (
                    $dateErrors !== false
                    && (
                        $dateErrors['warning_count'] > 0
                        || $dateErrors['error_count'] > 0
                    )
                )
                || $date->format('Y-m-d') !== $data['ngay_sinh']
            ) {
                $error = 'Vui lòng nhập ngày sinh hợp lệ.';
            }
        }

        if ($error !== '') {
            http_response_code(422);
            $this->renderAddForm($query, $error, $data);
            return;
        }

        try {
            (new StudentService())->createStudent($data);
        } catch (PDOException $exception) {
            if ($exception->getCode() !== '23000') {
                throw $exception;
            }

            http_response_code(422);
            $this->renderAddForm(
                $query,
                'Mã sinh viên này đã tồn tại. Vui lòng nhập mã khác.',
                $data
            );
            return;
        }

        $_SESSION['flash'] = 'Đã thêm sinh viên ' . $data['ma_sv'] . '.';

        $redirect = DOMAIN . '?controller=student&action=index';
        if ($query !== '') {
            $redirect .= '&q=' . rawurlencode($query);
        }

        header('Location: ' . $redirect, true, 303);
        exit;
    }

    private function renderAddForm($q, $error = '', $data = [])
    {
        $csrfToken = $this->getCsrfToken();
        include APP_ROOT . '/app/views/student/add.php';
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
            http_response_code(404);
            exit('Không tìm thấy sinh viên.');
        }

        $q = isset($_GET['q']) && is_string($_GET['q'])
            ? trim($_GET['q'])
            : '';

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
        $q = isset($_GET['q']) && is_string($_GET['q'])
            ? trim($_GET['q'])
            : '';

        include APP_ROOT . '/app/views/student/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Không hỗ trợ phương thức này.');
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