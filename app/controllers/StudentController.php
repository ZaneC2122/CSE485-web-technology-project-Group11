<?php
require_once APP_ROOT . '/app/services/StudentService.php';

class StudentController
{
    public function index()
    {
        if (isset($_GET['q'])) {
            $q = trim($_GET['q']);
        } else {
            $q = '';
        }

        $studentService = new StudentService();
        $students = $studentService->getAll($q);
        $total = $studentService->countAll();

        // Gan q vao moi duong link de tu khoa tim khong bi mat khi bam vao nut
        if ($q != '') {
            $qParam = '&q=' . urlencode($q);
        } else {
            $qParam = '';
        }

        include APP_ROOT . '/app/views/student/index.php';
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
}
