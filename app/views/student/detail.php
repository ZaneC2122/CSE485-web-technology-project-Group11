<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= defined('CSS_VERSION') ? CSS_VERSION : 6 ?>">
</head>
<body class="dash-page">
    <?php $backUrl = '?controller=student&action=index' . ($q !== '' ? '&q=' . urlencode($q) : ''); ?>
    <div class="popup">
        <section class="popup-card popup-form" aria-labelledby="student-detail-title">
            <div class="popup-head">
                <div>
                    <h4 id="student-detail-title" class="mb-1 fw-bold">Thông tin chi tiết sinh viên</h4>
                </div>
                <a href="<?= $backUrl ?>"
                   class="popup-close" title="Quay lại" aria-label="Quay lại danh sách sinh viên">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>

            <div class="popup-body">
                <h6 class="fw-bold mb-3">Thông tin sinh viên</h6>
                <div class="detail-grid">
                    <div>
                        <label class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control" value="<?= $student->ma_sv ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Họ tên</label>
                        <input type="text" class="form-control" value="<?= $student->ho_ten ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Ngày sinh</label>
                        <input type="text" class="form-control" value="<?= Student::formatDate($student->ngay_sinh) ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Giới tính</label>
                        <input type="text" class="form-control" value="<?= $student->gioi_tinh ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Tên lớp</label>
                        <input type="text" class="form-control" value="<?= $student->ten_lop ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Ngành</label>
                        <input type="text" class="form-control" value="<?= $student->nganh ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Khoa</label>
                        <input type="text" class="form-control" value="<?= $student->khoa ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Trạng thái</label>
                        <input type="text" class="form-control" value="<?= $student->trang_thai ?? '' ?>" readonly>
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold mb-1">Thông tin cá nhân</h6>
                <div class="detail-grid">
                    <div>
                        <label class="form-label">Người liên hệ</label>
                        <input type="text" class="form-control" value="<?= $student->nguoi_lien_he ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" value="<?= $student->sdt_nguoi_lien_he ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Số CCCD</label>
                        <input type="text" class="form-control" value="<?= $student->cccd ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Ngày cấp CCCD</label>
                        <input type="text" class="form-control" value="<?= Student::formatDate($student->ngay_cap_cccd) ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Nơi cấp CCCD</label>
                        <input type="text" class="form-control" value="<?= $student->noi_cap_cccd ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Dân tộc</label>
                        <input type="text" class="form-control" value="<?= $student->dan_toc ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Quốc tịch</label>
                        <input type="text" class="form-control" value="<?= $student->quoc_tich ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Ngày nhập học</label>
                        <input type="text" class="form-control" value="<?= Student::formatDate($student->ngay_nhap_hoc) ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Địa chỉ thường trú</label>
                        <input type="text" class="form-control" value="<?= $student->dia_chi_thuong_tru ?? '' ?>" readonly>
                    </div>
                    <div>
                        <label class="form-label">Nơi ở hiện tại</label>
                        <input type="text" class="form-control" value="<?= $student->noi_o_hien_tai ?? '' ?>" readonly>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" rows="3" readonly><?= $student->ghi_chu ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="popup-foot">
                <a href="<?= $backUrl ?>" class="btn btn-secondary">Quay lại</a>
            </div>
        </section>
    </div>
</body>
</html>
