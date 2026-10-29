<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= CSS_VERSION ?>">
</head>
<body class="dash-page">
<header class="topbar">
    <div class="container-fluid px-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div class="brand-icon">
                <a href="?controller=student&action=index">
                <i class="bi bi-mortarboard-fill"></i></a>
            </div>
            <span class="fw-bold">Quản lý sinh viên</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="topbar-user">Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?></strong></span>
        <form method="post" action="<?= DOMAIN ?>?controller=user&action=logout" class="m-0">
            <button type="submit" class="btn btn-topbar">Đăng xuất</button>
        </form>
        </div>
    </div>
</header>
<section class="hero">
    <div class="container">
        <h1 class="hero-title text-center">Danh sách sinh viên</h1>
    </div>
</section>
<main class="container pb-5">
    <?php if ($flash !== ''): ?>
        <div class="alert alert-success" role="status"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="card list-card">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
                <div>
                    <h2 class="h5 mb-1">Danh sách sinh viên</h2>
                    <div class="text-muted small">Tìm kiếm và quản lý hồ sơ nhanh chóng</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <form method="get" action="index.php" class="d-flex align-items-center gap-2 mb-0">
                        <input type="hidden" name="controller" value="student">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="search" name="q" class="form-control"
                                   placeholder="Tìm mã, tên, lớp, ngành…"
                                   value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <button type="submit" class="btn btn-icon btn-search" title="Tìm">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <a href="?controller=student&action=add<?= $qParam ?>" class="btn btn-icon btn-indigo" title="Thêm sinh viên" aria-label="Thêm sinh viên">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Mã sinh viên</th>
                            <th>Họ tên</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                            <th>Tên lớp</th>
                            <th>Ngành</th>
                            <th>Khoa</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Không tìm thấy sinh viên nào phù hợp.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($students as $student): ?>
                                <?php
                                if ($student->trang_thai == 'Đang học') {
                                    $badge = 'badge-green';
                                } else if ($student->trang_thai == 'Bảo lưu') {
                                    $badge = 'badge-amber';
                                } else {
                                    $badge = 'badge-red';
                                }
                                ?>
                                <tr>
                                    <td class="text-muted"><?= $student->ma_sv ?></td>
                                    <td class="fw-bold"><?= $student->ho_ten ?></td>
                                    <td><?= Student::formatDate($student->ngay_sinh) ?></td>
                                    <td><?= $student->gioi_tinh ?></td>
                                    <td><?= $student->ten_lop ?></td>
                                    <td><?= $student->nganh ?></td>
                                    <td><?= $student->khoa ?></td>
                                    <td><span class="badge-status <?= $badge ?>"><?= $student->trang_thai ?></span></td>
                                    <td class="text-end text-nowrap">
                                        <a href="?controller=student&action=detail&id=<?= $student->ma_sv ?><?= $qParam ?>"
                                           class="btn btn-icon btn-view" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
                                        <a href="?controller=student&action=edit&id=<?= $student->ma_sv ?><?= $qParam ?>"
                                           class="btn btn-icon btn-edit" title="Sửa"><i class="bi bi-pencil-square"></i></a>
                                        <button type="button" class="btn btn-icon btn-del delete-student-button"
                                                title="Xóa"
                                                data-student-id="<?= htmlspecialchars($student->ma_sv, ENT_QUOTES, 'UTF-8') ?>"
                                                data-student-name="<?= htmlspecialchars($student->ho_ten, ENT_QUOTES, 'UTF-8') ?>">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-muted small mt-3">
                Hiển thị <?= count($students) ?> / <?= $total ?> sinh viên
            </div>
        </div>
    </div>

    <div class="popup popup-confirm-overlay" id="delete-confirmation" role="dialog"
         aria-modal="true" aria-labelledby="delete-confirmation-title" hidden>
        <section class="popup-card popup-card--auto popup-narrow">
            <div class="popup-head">
                <div>
                    <h2 class="h5 mb-1" id="delete-confirmation-title">Xác nhận xóa sinh viên</h2>
                    <div class="text-muted small">Thao tác này không thể hoàn tác.</div>
                </div>
                <button type="button" class="popup-close" data-close-delete-dialog aria-label="Đóng">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="popup-body">
                <div class="danger-icon"><i class="bi bi-trash3"></i></div>
                <p class="popup-confirm-title">Bạn có chắc muốn xóa hồ sơ này?</p>
                <p class="text-muted mb-0">
                    Sinh viên <strong id="delete-student-name"></strong>
                    (<span id="delete-student-id"></span>) và thông tin chi tiết sẽ bị xóa.
                </p>
            </div>
            <form method="post" action="<?= DOMAIN ?>?controller=student&action=delete" class="popup-foot" id="delete-student-form">
                <input type="hidden" name="id" id="delete-student-id-input">
                <input type="hidden" name="q" value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>">
                <button type="button" class="btn btn-light" data-close-delete-dialog>Hủy</button>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash3 me-1"></i>Xóa sinh viên
                </button>
            </form>
        </section>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const deleteDialog = document.getElementById('delete-confirmation');
    const deleteStudentName = document.getElementById('delete-student-name');
    const deleteStudentId = document.getElementById('delete-student-id');
    const deleteStudentIdInput = document.getElementById('delete-student-id-input');
    let deleteTrigger = null;

    function closeDeleteDialog() {
        deleteDialog.hidden = true;
        document.body.style.overflow = '';
        if (deleteTrigger) {
            deleteTrigger.focus();
        }
    }

    document.querySelectorAll('.delete-student-button').forEach((button) => {
        button.addEventListener('click', () => {
            deleteTrigger = button;
            deleteStudentName.textContent = button.dataset.studentName;
            deleteStudentId.textContent = button.dataset.studentId;
            deleteStudentIdInput.value = button.dataset.studentId;
            deleteDialog.hidden = false;
            document.body.style.overflow = 'hidden';
            deleteDialog.querySelector('[data-close-delete-dialog]').focus();
        });
    });

    deleteDialog.querySelectorAll('[data-close-delete-dialog]').forEach((button) => {
        button.addEventListener('click', closeDeleteDialog);
    });

    deleteDialog.addEventListener('click', (event) => {
        if (event.target === deleteDialog) {
            closeDeleteDialog();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !deleteDialog.hidden) {
            closeDeleteDialog();
        }
    });
</script>
</body>
</html>
