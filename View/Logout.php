<?php
session_start();

// Xóa tất cả các biến session
$_SESSION = array();

// Xóa cookie session nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Hủy session
session_destroy();

// Chuyển hướng đến trang đăng nhập hoặc trang chính của ứng dụng
header("Location: /LTMNM_DeTai1/View/SignIn.php");
exit();
?>