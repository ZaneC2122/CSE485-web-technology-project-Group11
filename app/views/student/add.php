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
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="q" value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>">

            <div class="popup-head">
                <div>
                    <h4 class="mb-1 fw-bold">Thêm sinh viên</h4>
                    <small class="text-muted">Điền đầy đủ thông tin để tạo hồ sơ</small>
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
