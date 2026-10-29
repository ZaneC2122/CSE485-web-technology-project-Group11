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

    public function updateStudent($id, $data)
    {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $conn->beginTransaction();
        try {
            $updateStudent = $conn->prepare(
                "UPDATE student
                 SET ho_ten = ?, ngay_sinh = ?, gioi_tinh = ?, ten_lop = ?,
                     nganh = ?, khoa = ?, trang_thai = ?
                 WHERE ma_sv = ?"
            );
            $updateStudent->execute([
                $data['ho_ten'], $data['ngay_sinh'], $data['gioi_tinh'],
                $data['ten_lop'], $data['nganh'], $data['khoa'],
                $data['trang_thai'], $id
            ]);

            if ($updateStudent->rowCount() === 0) {
                $exists = $conn->prepare("SELECT COUNT(*) FROM student WHERE ma_sv = ?");
                $exists->execute([$id]);
                if ($exists->fetchColumn() == 0) {
                    $conn->rollBack();
                    return false;
                }
            }

            $upsertDetails = $conn->prepare(
                "INSERT INTO students
                    (ma_sv, cccd, ngay_cap_cccd, noi_cap_cccd, dan_toc, quoc_tich,
                     dia_chi_thuong_tru, noi_o_hien_tai, ngay_nhap_hoc,
                     nguoi_lien_he, sdt_nguoi_lien_he, ghi_chu)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                    cccd = VALUES(cccd),
                    ngay_cap_cccd = VALUES(ngay_cap_cccd),
                    noi_cap_cccd = VALUES(noi_cap_cccd),
                    dan_toc = VALUES(dan_toc),
                    quoc_tich = VALUES(quoc_tich),
                    dia_chi_thuong_tru = VALUES(dia_chi_thuong_tru),
                    noi_o_hien_tai = VALUES(noi_o_hien_tai),
                    ngay_nhap_hoc = VALUES(ngay_nhap_hoc),
                    nguoi_lien_he = VALUES(nguoi_lien_he),
                    sdt_nguoi_lien_he = VALUES(sdt_nguoi_lien_he),
                    ghi_chu = VALUES(ghi_chu)"
            );
            $upsertDetails->execute([
                $id, $data['cccd'], $data['ngay_cap_cccd'], $data['noi_cap_cccd'],
                $data['dan_toc'], $data['quoc_tich'], $data['dia_chi_thuong_tru'],
                $data['noi_o_hien_tai'], $data['ngay_nhap_hoc'], $data['nguoi_lien_he'],
                $data['sdt_nguoi_lien_he'], $data['ghi_chu']
            ]);

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
