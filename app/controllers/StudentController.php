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
        $additionalFields = [
            'cccd', 'ngay_cap_cccd', 'noi_cap_cccd', 'dan_toc', 'quoc_tich',
            'dia_chi_thuong_tru', 'noi_o_hien_tai', 'ngay_nhap_hoc',
            'nguoi_lien_he', 'sdt_nguoi_lien_he', 'ghi_chu'
        ];

        $data = [];
        foreach ($fields as $field) {
            $value = $_POST[$field] ?? '';
            $data[$field] = is_string($value) ? trim($value) : '';
        }
        foreach ($additionalFields as $field) {
            $value = $_POST[$field] ?? '';
            $value = is_string($value) ? trim($value) : '';
            $data[$field] = $value !== '' ? $value : null;
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
        if ($error === '') {
            $error = $this->validateStudentData($data, true);
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

        $maximumLengths = [
            'cccd' => 12,
            'noi_cap_cccd' => 100,
            'dan_toc' => 50,
            'quoc_tich' => 50,
            'dia_chi_thuong_tru' => 200,
            'noi_o_hien_tai' => 200,
            'nguoi_lien_he' => 100,
            'sdt_nguoi_lien_he' => 15,
            'ghi_chu' => 200,
        ];
        foreach ($maximumLengths as $field => $maximumLength) {
            if (
                $error === ''
                && $data[$field] !== null
                && !preg_match('/^.{0,' . $maximumLength . '}$/us', $data[$field])
            ) {
                $error = 'Thông tin bổ sung vượt quá độ dài cho phép.';
            }
        }

        foreach (['ngay_cap_cccd', 'ngay_nhap_hoc'] as $dateField) {
            if ($error !== '' || $data[$dateField] === null) {
                continue;
            }

            $date = DateTime::createFromFormat('!Y-m-d', $data[$dateField]);
            $dateErrors = DateTime::getLastErrors();
            if (
                !$date
                || (
                    $dateErrors !== false
                    && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0)
                )
                || $date->format('Y-m-d') !== $data[$dateField]
            ) {
                $error = 'Vui lòng nhập ngày cấp CCCD và ngày nhập học hợp lệ.';
            }
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
        $redirect = DOMAIN . '?controller=student&action=index';

        header('Location: ' . $redirect, true, 303);
        exit;
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

        $requiredFields = [
            'ho_ten', 'ngay_sinh', 'gioi_tinh', 'ten_lop', 'nganh', 'khoa',
            'trang_thai'
        ];
        $additionalFields = [
            'cccd', 'ngay_cap_cccd', 'noi_cap_cccd', 'dan_toc',
            'quoc_tich', 'dia_chi_thuong_tru', 'noi_o_hien_tai', 'ngay_nhap_hoc',
            'nguoi_lien_he', 'sdt_nguoi_lien_he', 'ghi_chu'
        ];

        $data = [];
        foreach (array_merge($requiredFields, $additionalFields) as $field) {
            $value = $_POST[$field] ?? '';
            $value = is_string($value) ? trim($value) : '';
            $data[$field] = $value !== '' ? $value : null;
        }

        $error = '';
        foreach ($requiredFields as $field) {
            if ($data[$field] === null) {
                $error = 'Vui lòng điền đầy đủ các trường thông tin bắt buộc.';
                break;
            }
        }
        if ($error === '') {
            $error = $this->validateStudentData($data, false);
        }

        $maximumLengths = [
            'ho_ten' => 100,
            'ten_lop' => 50,
            'nganh' => 100,
            'khoa' => 100,
            'cccd' => 12,
            'noi_cap_cccd' => 100,
            'dan_toc' => 50,
            'quoc_tich' => 50,
            'dia_chi_thuong_tru' => 200,
            'noi_o_hien_tai' => 200,
            'nguoi_lien_he' => 100,
            'sdt_nguoi_lien_he' => 15,
            'ghi_chu' => 200,
        ];
        foreach ($maximumLengths as $field => $maximumLength) {
            if (
                $error === ''
                && $data[$field] !== null
                && !preg_match('/^.{0,' . $maximumLength . '}$/us', $data[$field])
            ) {
                $error = 'Thông tin nhập vào vượt quá độ dài cho phép.';
            }
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
                    && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0)
                )
                || $date->format('Y-m-d') !== $data['ngay_sinh']
            ) {
                $error = 'Vui lòng nhập ngày sinh hợp lệ.';
            }
        }

        foreach (['ngay_cap_cccd', 'ngay_nhap_hoc'] as $dateField) {
            if ($error !== '' || $data[$dateField] === null) {
                continue;
            }

            $date = DateTime::createFromFormat('!Y-m-d', $data[$dateField]);
            $dateErrors = DateTime::getLastErrors();
            if (
                !$date
                || (
                    $dateErrors !== false
                    && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0)
                )
                || $date->format('Y-m-d') !== $data[$dateField]
            ) {
                $error = 'Vui lòng nhập ngày tháng bổ sung hợp lệ.';
            }
        }

        if ($error !== '') {
            $studentService = new StudentService();
            $student = $studentService->getStudentById($id);
            if (!$student) {
                http_response_code(404);
                exit('Không tìm thấy sinh viên.');
            }

            foreach (array_merge($requiredFields, $additionalFields) as $field) {
                $student->$field = $data[$field] ?? '';
            }

            $q = isset($_POST['q']) && is_string($_POST['q']) ? trim($_POST['q']) : '';
            http_response_code(422);
            include APP_ROOT . '/app/views/student/edit.php';
            return;
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

    private function validateStudentData($data, $isCreate)
    {
        if ($isCreate && !preg_match('/^[A-Za-z0-9]{1,10}$/D', $data['ma_sv'])) {
            return 'Mã sinh viên chỉ được nhập chữ và số, tối đa 10 ký tự.';
        }

        if (!preg_match('/^[\p{L}\s]+$/u', $data['ho_ten'])) {
            return 'Họ tên chỉ được nhập chữ và khoảng trắng.';
        }

        if (!preg_match('/^[\p{L}0-9][\p{L}0-9\s.-]*$/u', $data['ten_lop'])) {
            return 'Tên lớp không hợp lệ.';
        }

        foreach (['nganh', 'khoa'] as $field) {
            if (!preg_match('/^[\p{L}0-9][\p{L}0-9\s.,()\/-]*$/u', $data[$field])) {
                return 'Ngành và khoa chỉ được nhập chữ, số và ký tự tên hợp lệ.';
            }
        }

        if ($data['cccd'] !== null && !preg_match('/^[0-9]{12}$/D', $data['cccd'])) {
            return 'Số CCCD phải gồm đúng 12 chữ số.';
        }

        if ($data['sdt_nguoi_lien_he'] !== null
            && !preg_match('/^0(3[2-9]|5[2689]|7[06-9]|8[1-9]|9[0-46-9])[0-9]{7}$/D', $data['sdt_nguoi_lien_he'])
        ) {
            return 'Số điện thoại phải gồm 10 chữ số và bắt đầu bằng 03, 05, 07, 08 hoặc 09.';
        }

        foreach (['dan_toc', 'quoc_tich', 'nguoi_lien_he'] as $field) {
            if ($data[$field] !== null && !preg_match('/^[\p{L}\s.]+$/u', $data[$field])) {
                return 'Dân tộc, quốc tịch và người liên hệ chỉ được nhập chữ.';
            }
        }

        $birthDate = $this->parseValidDate($data['ngay_sinh']);
        if (!$birthDate) {
            return 'Vui lòng nhập ngày sinh hợp lệ.';
        }
        $today = new DateTimeImmutable('today');
        if ($birthDate >= $today) {
            return 'Ngày sinh phải nhỏ hơn ngày hiện tại.';
        }

        foreach (['ngay_cap_cccd', 'ngay_nhap_hoc'] as $field) {
            if ($data[$field] === null) {
                continue;
            }
            $date = $this->parseValidDate($data[$field]);
            if (!$date) {
                return 'Ngày cấp CCCD và ngày nhập học phải hợp lệ.';
            }
            if ($date > $today) {
                return 'Ngày cấp CCCD và ngày nhập học không được vượt quá ngày hiện tại.';
            }
            if ($date < $birthDate) {
                return 'Ngày cấp CCCD và ngày nhập học không được trước ngày sinh.';
            }
        }

        return '';
    }

    private function parseValidDate($value)
    {
        if (!is_string($value) || $value === '') {
            return null;
        }
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        $errors = DateTimeImmutable::getLastErrors();
        if (!$date || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
            return null;
        }
        return $date->format('Y-m-d') === $value ? $date : null;
    }
}