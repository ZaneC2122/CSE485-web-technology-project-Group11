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
            <!-- Hoan: cho nay dat "Xin chao, <ten user>" + nut Dang xuat -->
        </div>
    </div>
</header>
<section class="hero">
    <div class="container">
        <h1 class="hero-title text-center">Danh sách sinh viên</h1>
    </div>
</section>
<main class="container pb-5">

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
                                   value="<?= $q ?>">
                        </div>
                        <button type="submit" class="btn btn-icon btn-search" title="Tìm">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <a href="?controller=student&action=add<?= $qParam ?>" class="btn btn-icon btn-indigo" title="Thêm sinh viên">
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
                                        <a href="?controller=student&action=delete&id=<?= $student->ma_sv ?><?= $qParam ?>"
                                           class="btn btn-icon btn-del" title="Xóa"><i class="bi bi-trash3"></i></a>
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

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
