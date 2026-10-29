<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= CSS_VERSION ?>">
</head>
<body class="auth-page">
<main class="auth-card">
    <div class="auth-brand">
        <div class="auth-brand-icon"><i class="bi bi-mortarboard"></i></div>
        <div>
            <div class="fw-bold">Quản lý sinh viên</div>
        </div>
    </div>

    <div class="auth-kicker">Cổng thông tin</div>
    <h1 class="auth-title">Tạo tài khoản</h1>
    <p class="auth-sub">Đăng ký tài khoản để truy cập bảng quản lý sinh viên.</p>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger py-2" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= DOMAIN ?>?controller=user&action=register">

        <div class="mb-3">
            <label for="ho_ten" class="form-label">Họ và tên</label>
            <input type="text" id="ho_ten" name="ho_ten" class="form-control"
                   placeholder="Nguyễn Văn A" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
                   maxlength="100" autocomplete="name" required autofocus>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control"
                   placeholder="ban@example.com" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                   maxlength="100" autocomplete="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="Ít nhất 8 ký tự" autocomplete="off" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                   placeholder="Nhập lại mật khẩu" autocomplete="off" required>
        </div>

        <button type="submit" class="btn btn-indigo w-100 py-2">Đăng ký</button>
    </form>

    <p class="auth-foot">Đã có tài khoản? <a class="auth-link text-decoration-none" href="<?= DOMAIN ?>?controller=user&action=login">Đăng nhập</a></p>
</main>
</body>
</html>
