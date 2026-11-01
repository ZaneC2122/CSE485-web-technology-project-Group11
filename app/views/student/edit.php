<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= defined('CSS_VERSION') ? CSS_VERSION : 6 ?>">
</head>
<body class="dash-page">
    <div class="popup">
        <form class="popup-card popup-form" action="?controller=student&action=update&id=<?= urlencode($student->ma_sv) ?>" method="post">
            <input type="hidden" name="q" value="<?= $q ?>">

            <div class="popup-head">
                <div>
                    <h4 class="mb-1 fw-bold">Sửa thông tin sinh viên</h4>
                </div>
                <a href="?controller=student&action=index<?= $q !== '' ? '&q=' . urlencode($q) : '' ?>" class="popup-close" title="Đóng" aria-label="Đóng">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>

            <div class="popup-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2" role="alert"><?= $error ?></div>
                <?php endif; ?>
                <h6 class="fw-bold mb-3">Thông tin sinh viên</h6>
                <div class="detail-grid">
                    <div>
                        <label for="ma_sv" class="form-label">Mã sinh viên *</label>
                        <input type="text" name="ma_sv" id="ma_sv" class="form-control" value="<?= $student->ma_sv ?>" readonly>
                    </div>
                    <div>
                        <label for="ho_ten" class="form-label">Họ tên *</label>
                        <input type="text" name="ho_ten" id="ho_ten" class="form-control" value="<?= $student->ho_ten ?? '' ?>" maxlength="100" pattern="[^\d]+" title="Họ tên không được chứa chữ số" required>
                    </div>
                    <div>
                        <label for="ngay_sinh" class="form-label">Ngày sinh *</label>
                        <input type="date" name="ngay_sinh" id="ngay_sinh" class="form-control" value="<?= $student->ngay_sinh ?? '' ?>" max="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div>
                        <label for="gioi_tinh" class="form-label">Giới tính *</label>
                        <select name="gioi_tinh" id="gioi_tinh" class="form-control" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach (['Nam', 'Nữ'] as $value): ?>
                                <option value="<?= $value ?>" <?= ($student->gioi_tinh ?? '') === $value ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="ten_lop" class="form-label">Tên lớp *</label>
                        <input type="text" name="ten_lop" id="ten_lop" class="form-control" value="<?= $student->ten_lop ?? '' ?>" maxlength="50" required>
                    </div>
                    <div>
                        <label for="nganh" class="form-label">Ngành *</label>
                        <input type="text" name="nganh" id="nganh" class="form-control" value="<?= $student->nganh ?? '' ?>" maxlength="100" required>
                    </div>
                    <div>
                        <label for="khoa" class="form-label">Khoa *</label>
                        <input type="text" name="khoa" id="khoa" class="form-control" value="<?= $student->khoa ?? '' ?>" maxlength="100" required>
                    </div>
                    <div>
                        <label for="trang_thai" class="form-label">Trạng thái *</label>
                        <select name="trang_thai" id="trang_thai" class="form-control" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach (['Đang học', 'Bảo lưu', 'Thôi học'] as $value): ?>
                                <option value="<?= $value ?>" <?= ($student->trang_thai ?? '') === $value ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold mb-1">Thông tin cá nhân</h6>
                <div class="detail-grid">
                    <div>
                        <label for="nguoi_lien_he" class="form-label">Người liên hệ</label>
                        <input type="text" name="nguoi_lien_he" id="nguoi_lien_he" class="form-control" value="<?= $student->nguoi_lien_he ?? '' ?>">
                    </div>
                    <div>
                        <label for="sdt_nguoi_lien_he" class="form-label">Số điện thoại</label>
                        <input type="tel" name="sdt_nguoi_lien_he" id="sdt_nguoi_lien_he" class="form-control" value="<?= $student->sdt_nguoi_lien_he ?? '' ?>" maxlength="10" inputmode="numeric" pattern="0(3[2-9]|5[2689]|7[06-9]|8[1-9]|9[0-46-9])[0-9]{7}" title="Nhập số điện thoại di động Việt Nam hợp lệ gồm 10 chữ số">
                    </div>
                    <div>
                        <label for="cccd" class="form-label">Số CCCD</label>
                        <input type="text" name="cccd" id="cccd" class="form-control" value="<?= $student->cccd ?? '' ?>" maxlength="12" inputmode="numeric" pattern="[0-9]{12}" title="Số CCCD phải gồm đúng 12 chữ số">
                    </div>
                    <div>
                        <label for="ngay_cap_cccd" class="form-label">Ngày cấp CCCD</label>
                        <input type="date" name="ngay_cap_cccd" id="ngay_cap_cccd" class="form-control" value="<?= $student->ngay_cap_cccd ?? '' ?>" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div>
                        <label for="noi_cap_cccd" class="form-label">Nơi cấp CCCD</label>
                        <input type="text" name="noi_cap_cccd" id="noi_cap_cccd" class="form-control" value="<?= $student->noi_cap_cccd ?? '' ?>">
                    </div>
                    <div>
                        <label for="dan_toc" class="form-label">Dân tộc</label>
                        <input type="text" name="dan_toc" id="dan_toc" class="form-control" value="<?= $student->dan_toc ?? '' ?>">
                    </div>
                    <div>
                        <label for="quoc_tich" class="form-label">Quốc tịch</label>
                        <input type="text" name="quoc_tich" id="quoc_tich" class="form-control" value="<?= $student->quoc_tich ?? '' ?>">
                    </div>
                    <div>
                        <label for="ngay_nhap_hoc" class="form-label">Ngày nhập học</label>
                        <input type="date" name="ngay_nhap_hoc" id="ngay_nhap_hoc" class="form-control" value="<?= $student->ngay_nhap_hoc ?? '' ?>" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div>
                        <label for="dia_chi_thuong_tru" class="form-label">Địa chỉ thường trú</label>
                        <input type="text" name="dia_chi_thuong_tru" id="dia_chi_thuong_tru" class="form-control" value="<?= $student->dia_chi_thuong_tru ?? '' ?>">
                    </div>
                    <div>
                        <label for="noi_o_hien_tai" class="form-label">Nơi ở hiện tại</label>
                        <input type="text" name="noi_o_hien_tai" id="noi_o_hien_tai" class="form-control" value="<?= $student->noi_o_hien_tai ?? '' ?>">
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label for="ghi_chu" class="form-label">Ghi chú</label>
                        <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3"><?= $student->ghi_chu ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="popup-foot">
                <a href="?controller=student&action=index<?= $q !== '' ? '&q=' . urlencode($q) : '' ?>" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary" name="btn_update">Cập nhật</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
