<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Campus</title>
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
            <div class="fw-bold">Campus</div>
            <div class="text-muted small">Quản lý sinh viên</div>
        </div>
    </div>

    <div class="auth-kicker">Cổng thông tin</div>
    <h1 class="auth-title">Chào mừng bạn</h1>
    <p class="auth-sub">Đăng nhập để tiếp tục đến bảng quản lý sinh viên.</p>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger py-2" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= DOMAIN ?>?controller=user&action=login">
        <!-- Gửi token phiên để controller kiểm tra yêu cầu đăng nhập. -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control"
                   placeholder="ban@example.com" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                   autocomplete="username" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="Ít nhất 8 ký tự" autocomplete="current-password" required>
        </div>

        <button type="submit" class="btn btn-indigo w-100 py-2">Đăng nhập</button>
    </form>

    <p class="auth-foot">Chưa có tài khoản? <span class="auth-link">Đăng ký</span></p>
    <div class="auth-note">
        Dùng email và mật khẩu đã được cấp để đăng nhập vào hệ thống quản lý sinh viên.
    </div>
</main>
</body>
</html>
