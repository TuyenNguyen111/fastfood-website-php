<?php
session_start();

if(isset($_POST['product_id'])) {
    // Lấy ID sản phẩm từ yêu cầu POST
    $product_id = $_POST['product_id'];

    // Thêm sản phẩm vào giỏ hàng trong session
    if(isset($_SESSION['cart'][$product_id])) {
        // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng lên 1
        $_SESSION['cart'][$product_id]++;
    } else {
        // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới và đặt số lượng là 1
        $_SESSION['cart'][$product_id] = 1;
    }

    // Trả về thông báo thành công (có thể không cần thiết)
    echo "Sản phẩm đã được thêm vào giỏ hàng.";
}
?>

