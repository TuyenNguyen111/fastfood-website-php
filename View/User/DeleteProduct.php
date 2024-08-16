<?php
session_start();

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];

    if(isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]); // Xóa sản phẩm khỏi giỏ hàng
    }
}

header("Location: Cart.php"); // Chuyển hướng trở lại trang giỏ hàng
exit();
?>
