<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= defined('CSS_VERSION') ? CSS_VERSION : 7 ?>">
</head>
<body class="dash-page">
    <div class="popup">
        <form class="popup-card popup-form" action="<?= DOMAIN ?>?controller=student&action=create" method="post">
            <input type="hidden" name="q" value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>">

            <div class="popup-head">
                <div>
                    <h4 class="mb-1 fw-bold">Thêm sinh viên</h4>
                </div>
                <a href="?controller=student&action=index<?= $q !== '' ? '&q=' . urlencode($q) : '' ?>"
                   class="popup-close" title="Đóng" aria-label="Đóng">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>

            <div class="popup-body">
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger py-2" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <h6 class="fw-bold mb-3">Thông tin sinh viên</h6>
                <div class="detail-grid">
                    <div>
                        <label for="ma_sv" class="form-label">Mã sinh viên *</label>
                        <input type="text" name="ma_sv" id="ma_sv" class="form-control"
                               value="<?= htmlspecialchars($data['ma_sv'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="10" required autofocus>
                    </div>
                    <div>
                        <label for="ho_ten" class="form-label">Họ tên *</label>
                        <input type="text" name="ho_ten" id="ho_ten" class="form-control"
                               value="<?= htmlspecialchars($data['ho_ten'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="100" required>
                    </div>
                    <div>
                        <label for="ngay_sinh" class="form-label">Ngày sinh *</label>
                        <input type="date" name="ngay_sinh" id="ngay_sinh" class="form-control"
                               value="<?= htmlspecialchars($data['ngay_sinh'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div>
                        <label for="gioi_tinh" class="form-label">Giới tính *</label>
                        <select name="gioi_tinh" id="gioi_tinh" class="form-control" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach (['Nam', 'Nữ'] as $value): ?>
                                <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>"
                                    <?= ($data['gioi_tinh'] ?? '') === $value ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="ten_lop" class="form-label">Tên lớp *</label>
                        <input type="text" name="ten_lop" id="ten_lop" class="form-control"
                               value="<?= htmlspecialchars($data['ten_lop'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="50" required>
                    </div>
                    <div>
                        <label for="nganh" class="form-label">Ngành *</label>
                        <input type="text" name="nganh" id="nganh" class="form-control"
                               value="<?= htmlspecialchars($data['nganh'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="100" required>
                    </div>
                    <div>
                        <label for="khoa" class="form-label">Khoa *</label>
                        <input type="text" name="khoa" id="khoa" class="form-control"
                               value="<?= htmlspecialchars($data['khoa'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="100" required>
                    </div>
                    <div>
                        <label for="trang_thai" class="form-label">Trạng thái *</label>
                        <select name="trang_thai" id="trang_thai" class="form-control" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach (['Đang học', 'Bảo lưu', 'Thôi học'] as $value): ?>
                                <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>"
                                    <?= ($data['trang_thai'] ?? '') === $value ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold mb-3">Thông tin cá nhân</h6>
                <div class="detail-grid">
                    <div>
                        <label for="cccd" class="form-label">Căn cước công dân</label>
                        <input type="text" name="cccd" id="cccd" class="form-control"
                               value="<?= htmlspecialchars($data['cccd'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="12">
                    </div>
                    <div>
                        <label for="ngay_cap_cccd" class="form-label">Ngày cấp CCCD</label>
                        <input type="date" name="ngay_cap_cccd" id="ngay_cap_cccd" class="form-control"
                               value="<?= htmlspecialchars($data['ngay_cap_cccd'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div>
                        <label for="noi_cap_cccd" class="form-label">Nơi cấp CCCD</label>
                        <input type="text" name="noi_cap_cccd" id="noi_cap_cccd" class="form-control"
                               value="<?= htmlspecialchars($data['noi_cap_cccd'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="100">
                    </div>
                    <div>
                        <label for="dan_toc" class="form-label">Dân tộc</label>
                        <input type="text" name="dan_toc" id="dan_toc" class="form-control"
                               value="<?= htmlspecialchars($data['dan_toc'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="50">
                    </div>
                    <div>
                        <label for="quoc_tich" class="form-label">Quốc tịch</label>
                        <input type="text" name="quoc_tich" id="quoc_tich" class="form-control"
                               value="<?= htmlspecialchars($data['quoc_tich'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="50">
                    </div>
                    <div>
                        <label for="dia_chi_thuong_tru" class="form-label">Địa chỉ thường trú</label>
                        <input type="text" name="dia_chi_thuong_tru" id="dia_chi_thuong_tru" class="form-control"
                               value="<?= htmlspecialchars($data['dia_chi_thuong_tru'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="200">
                    </div>
                    <div>
                        <label for="noi_o_hien_tai" class="form-label">Nơi ở hiện tại</label>
                        <input type="text" name="noi_o_hien_tai" id="noi_o_hien_tai" class="form-control"
                               value="<?= htmlspecialchars($data['noi_o_hien_tai'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="200">
                    </div>
                    <div>
                        <label for="ngay_nhap_hoc" class="form-label">Ngày nhập học</label>
                        <input type="date" name="ngay_nhap_hoc" id="ngay_nhap_hoc" class="form-control"
                               value="<?= htmlspecialchars($data['ngay_nhap_hoc'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div>
                        <label for="nguoi_lien_he" class="form-label">Người liên hệ</label>
                        <input type="text" name="nguoi_lien_he" id="nguoi_lien_he" class="form-control"
                               value="<?= htmlspecialchars($data['nguoi_lien_he'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="100">
                    </div>
                    <div>
                        <label for="sdt_nguoi_lien_he" class="form-label">Số điện thoại người liên hệ</label>
                        <input type="tel" name="sdt_nguoi_lien_he" id="sdt_nguoi_lien_he" class="form-control"
                               value="<?= htmlspecialchars($data['sdt_nguoi_lien_he'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="15">
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label for="ghi_chu" class="form-label">Ghi chú</label>
                        <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3"
                                  maxlength="200"><?= htmlspecialchars($data['ghi_chu'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="popup-foot">
                <a href="?controller=student&action=index<?= $q !== '' ? '&q=' . urlencode($q) : '' ?>"
                   class="btn btn-light">Hủy</a>
                <button type="submit" class="btn btn-indigo">
                    <i class="bi bi-plus-lg me-1"></i>Thêm sinh viên
                </button>
            </div>
        </form>
    </div>
</body>
</html>
