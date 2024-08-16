<?php
// Include file Header.php để sử dụng các khai báo và định nghĩa trong đó
include '../Header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../../DataBase/Connect.php'; 
// Kiểm tra xem yêu cầu gửi đến là phương thức POST hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin đặt hàng từ form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method']; // Phương thức thanh toán

    // Thực hiện thêm thông tin đặt hàng vào cơ sở dữ liệu
    try {
        // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng đơn hàng
        $sql = "INSERT INTO donhang (TenKhachHang, SoDienThoai, DiaChi, PhuongThucThanhToan) VALUES (?, ?, ?, ?)";
        
        // Sử dụng prepare statement để chuẩn bị câu lệnh SQL
        $stmt = $conn->prepare($sql);
        
        // Bind các giá trị vào các tham số ràng buộc trong câu lệnh SQL
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $phone, PDO::PARAM_STR);
        $stmt->bindParam(3, $address, PDO::PARAM_STR);
        $stmt->bindParam(4, $payment_method, PDO::PARAM_STR);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Xóa dữ liệu giỏ hàng của người dùng sau khi đã đặt hàng thành công
        unset($_SESSION['cart']);
        
        // Hiển thị thông báo đặt hàng thành công
        echo "<p class='text-center'>Đặt hàng thành công!</p>";
    } catch (PDOException $e) {
        // Hiển thị thông báo lỗi nếu có lỗi xảy ra khi thêm đơn hàng vào CSDL
        echo "<p class='text-center'>Đã xảy ra lỗi khi đặt hàng: " . $e->getMessage() . "</p>";
    }
}

// Include file Footer.php để đóng các thẻ HTML và tải các tập tin JavaScript cuối cùng
include '../Footer.php';
?>
