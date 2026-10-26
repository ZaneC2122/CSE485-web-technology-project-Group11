
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thông tin chi tiết</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css"></head>

<body>
    <header class="topbar">
        <div class="container-fluid px-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="brand-icon">
                    <a href="?controller=student&action=index">
                    <i class="bi bi-mortarboard-fill"></i></a>
                </div>

                <span class="fw-bold">Quản lý sinh viên</span>
            </div>
        </div>
    </header>

    <main class="detail-container">

        <div class="page-heading">
            <h1>Thông tin chi tiết</h1>
        </div>

        <section class="detail-card">

            <div class="detail-card-header">
                <div class="detail-icon">
                    <i class="bi bi-person-vcard"></i>
                </div>

                <div>
                    <h5>Thông tin cá nhân</h5>
                </div>
            </div>

            <div class="detail-card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control"
                               value="<?= $student->ma_sv ?>" readonly>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control"
                               value="<?= $student->ho_ten ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Ngày sinh</label>
                        <input type="text" class="form-control"
                               value="<?= Student::formatDate($student->ngay_sinh) ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Giới tính</label>
                        <input type="text" class="form-control"
                               value="<?= $student->gioi_tinh ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Dân tộc</label>
                        <input type="text" class="form-control"
                               value="<?= $student->dan_toc ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Số CCCD</label>
                        <input type="text" class="form-control"
                               value="<?= $student->cccd ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Quốc tịch</label>
                        <input type="text" class="form-control"
                               value="<?= $student->quoc_tich ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ngày cấp CCCD</label>
                        <input type="text" class="form-control"
                               value="<?= Student::formatDate($student->ngay_cap_cccd) ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nơi cấp CCCD</label>
                        <input type="text" class="form-control"
                               value="<?= $student->noi_cap_cccd ?>" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Địa chỉ thường trú</label>
                        <input type="text" class="form-control"
                               value="<?= $student->dia_chi_thuong_tru ?>" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Nơi ở hiện tại</label>
                        <input type="text" class="form-control"
                               value="<?= $student->noi_o_hien_tai ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Người liên hệ</label>
                        <input type="text" class="form-control"
                               value="<?= $student->nguoi_lien_he ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Số điện thoại người liên hệ</label>
                        <input type="text" class="form-control"
                               value="<?= $student->sdt_nguoi_lien_he ?>" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" readonly><?= $student->ghi_chu ?></textarea>
                    </div>

                </div>
            </div>
        </section>

        <section class="detail-card">

            <div class="detail-card-header">
                <div class="detail-icon">
                    <i class="bi bi-mortarboard"></i>
                </div>

                <div>
                    <h5>Thông tin theo trường</h5>
                </div>
            </div>

            <div class="detail-card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control"
                               value="<?= $student->ma_sv ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ngày nhập học</label>
                        <input type="text" class="form-control"
                               value="<?= Student::formatDate($student->ngay_nhap_hoc) ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Lớp</label>
                        <input type="text" class="form-control"
                               value="<?= $student->ten_lop ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Ngành học</label>
                        <input type="text" class="form-control"
                               value="<?= $student->nganh ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Khoa</label>
                        <input type="text" class="form-control"
                               value="<?= $student->khoa ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Trạng thái sinh viên</label>
                        <input type="text" class="form-control"
                               value="<?= $student->trang_thai ?>" readonly>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
