<?php
require_once APP_ROOT . '/app/models/Student.php';

class StudentService
{
    // Lay danh sach sinh vien. $q = tu khoa tim kiem, de trong thi lay het.
    public function getAll($q)
    {
        $students = [];
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $sql = "SELECT * FROM student";

        if ($q != '') {
            $like = '%' . $q . '%';
            $sql = $sql . " WHERE (ma_sv LIKE ? OR ho_ten LIKE ? OR ten_lop LIKE ? OR nganh LIKE ? OR khoa LIKE ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$like, $like, $like, $like, $like]);
        } else {
            $sql = $sql . " ORDER BY ma_sv";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        while ($row = $stmt->fetch()) {
            $student = new Student($row['ma_sv'], $row['ho_ten'], $row['ngay_sinh'], $row['gioi_tinh'],
                                   $row['ten_lop'], $row['nganh'], $row['khoa'], $row['trang_thai']);
            $students[] = $student;
        }
        return $students;
    }

    // Dem tong so sinh vien trong bang (khong tinh bo loc tim kiem)
    public function countAll()
    {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM student");
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    //Lấy ttin sinh viên thông qua id
    public function getStudentById($id)
    {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $sql = "SELECT *
                FROM student s
                LEFT JOIN students sd ON s.ma_sv = sd.ma_sv
                WHERE s.ma_sv = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function deleteStudent($id)
    {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $conn->beginTransaction();
        try {
            $deleteDetails = $conn->prepare("DELETE FROM students WHERE ma_sv = ?");
            $deleteDetails->execute([$id]);

            $deleteStudent = $conn->prepare("DELETE FROM student WHERE ma_sv = ?");
            $deleteStudent->execute([$id]);

            if ($deleteStudent->rowCount() !== 1) {
                $conn->rollBack();
                return false;
            }

            $conn->commit();
            return true;
        } catch (Throwable $exception) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            throw $exception;
        }
    }
}
