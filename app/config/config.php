<?php
define('APP_ROOT', dirname(__FILE__, 3));
define('DOMAIN', 'http://localhost/BTL-QLSV/public/');
// Tang so nay moi lan sua style.css de trinh duyet tai lai file (chong cache)
define('CSS_VERSION', '6');

// May nao co tai khoan MySQL khac (user/pass khac root rong) thi tao file
// config.local.php cung thu muc, chi can define lai 4 hang DB_* o trong do.
if (file_exists(APP_ROOT . '/app/config/config.local.php')) {
    require_once APP_ROOT . '/app/config/config.local.php';
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'btl_qlsv');
}
