<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if(!isset($_SESSION['user_id']))
		{
			header("Location: /LTMNM_DeTai1/View/SignIn.php");
			exit();
		}
include '../Header.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'vendor/PHPMailer/src/Exception.php';
include 'vendor/PHPMailer/src/PHPMailer.php';
include 'vendor/PHPMailer/src/SMTP.php';

include __DIR__ . '/../../DataBase/Connect.php';

// Kiểm tra kết nối CSDL
if (!$conn) {
    die("Kết nối CSDL không thành công: " . $conn->errorInfo());
}
			if(isset($_SESSION['username']))
{
	$ten=$_SESSION['username'];
}

$sql4="select * from nguoidung where tendangnhap='$ten' limit 1";
$result4=$conn->query($sql4);
$row4=$result4->fetch();

// Kiểm tra nếu form đặt hàng đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email']; // Lấy địa chỉ email từ form
    $payment_method = $_POST['payment_method'];
    echo 
    // Bắt đầu transaction
    $conn->beginTransaction();
    
    try {
        // Lưu thông tin đơn hàng vào cơ sở dữ liệu
        $sql_insert_order = "INSERT INTO donhang (MaKH, TenKhachHang, SoDienThoai, DiaChi, PhuongThucThanhToan, ThoiGianTaoDon) 
                             VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_order);
        $stmt->execute([$_SESSION['user_id'], $name, $phone, $address, $payment_method, date('Y-m-d H:i:s')]);
        $order_id = $conn->lastInsertId();

        // Lưu thông tin chi tiết đơn hàng
        $sql_insert_order = "INSERT INTO chitietdonhang (MaDon, MaSanPham, SoLuong, Gia) 
                             VALUES (?, ?, ?, ?)";
                             
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            // Lấy giá sản phẩm từ cơ sở dữ liệu
            $sql_get_price = "SELECT Gia FROM sanpham WHERE MaSanPham = ?";
            $stmt_get_price = $conn->prepare($sql_get_price);
            $stmt_get_price->execute([$product_id]);
            $product = $stmt_get_price->fetch(PDO::FETCH_ASSOC);
            $product_price = $product['Gia'];

            // Chèn chi tiết đơn hàng với giá vừa lấy được
            $sql_insert_order_detail = "INSERT INTO chitietdonhang (MaDon, MaSanPham, SoLuong, Gia) VALUES (?, ?, ?, ?)";
            $stmt_insert_order_detail = $conn->prepare($sql_insert_order_detail);
            $stmt_insert_order_detail->execute([$order_id, $product_id, $quantity, $product_price]);
        }

        // Khởi tạo đối tượng PHPMailer
        $mail = new PHPMailer(true);

        // Cấu hình gửi email
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'duongtugiaucuong@gmail.com';                     
        $mail->Password   = 'yfuedyjohrinlyhd';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;                                    
    
        // Người nhận
        $mail->setFrom('duongtugiaucuong@gmail.com', 'Cake DouF');
        $mail->addAddress($email, $name);  

        // Lấy thông tin sản phẩm từ giỏ hàng
        $order_details = '';
        $total_price = 0;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql = "SELECT TenSanPham, Gia FROM sanpham WHERE MaSanPham = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            $product_name = $product['TenSanPham'];
            $product_price = $product['Gia'];
            $subtotal_price = $product_price * $quantity;
            $total_price += $subtotal_price;

            $order_details .= "<tr>
                                   <td>$product_name</td>
                                   <td>$quantity</td>
                                   <td>$product_price VNĐ</td>
                                   <td>$subtotal_price VNĐ</td>
                               </tr>";
        }

        $order_details .= "<tr>
                               <td colspan='3' class='text-end fw-bold'>Tổng tiền:</td>
                               <td class='fw-bold'>$total_price VNĐ</td>
                           </tr>";

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = '=?UTF-8?B?' . base64_encode('Xác nhận đơn hàng') . '?=';
        $mail->Body = "<p>Chào $name,</p>
                       <p>Cảm ơn bạn đã đặt hàng. Thông tin đơn hàng của bạn như sau:</p>
                       <p><strong>Chi tiết đơn hàng:</strong></p>
                       <p>Họ và tên: $name</p>
                       <p>Số điện thoại: $phone</p>
                       <p>Địa chỉ: $address</p>
                       <p>Phương thức thanh toán: $payment_method</p>
                       <table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>
                           <thead>
                               <tr>
                                   <th>Tên sản phẩm</th>
                                   <th>Số lượng</th>
                                   <th>Giá</th>
                                   <th>Tổng</th>
                               </tr>
                           </thead>
                           <tbody>
                               $order_details
                           </tbody>
                       </table>
                       <p>Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.</p>
                       <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>";
        
        $mail->send();
        
        // Commit transaction sau khi tất cả mọi thứ thành công
        $conn->commit();
        
        echo "<center><div style='height:450px'>Đơn hàng đã được đặt thành công và email xác nhận đã được gửi.</div></center>";
        
        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi xảy ra
        $conn->rollBack();
        echo "Đơn hàng đã được đặt, nhưng không thể gửi email xác nhận. Lỗi gửi email: {$mail->ErrorInfo}";
    }
} else {
    // Kiểm tra xem có sản phẩm nào trong giỏ hàng không
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Mảng các ID sản phẩm trong giỏ hàng
        $product_ids = array_keys($_SESSION['cart']);

        // Tạo một mảng chứa các tham số ràng buộc
        $params = array_fill(0, count($product_ids), '?');

        // Tạo một chuỗi tham số ràng buộc để sử dụng trong câu truy vấn SQL
        $placeholders = implode(',', $params);

        // Câu truy vấn lấy thông tin các sản phẩm trong giỏ hàng
        $sql = "SELECT MaSanPham, TenSanPham, Gia, URLHinhAnh FROM sanpham WHERE MaSanPham IN ($placeholders)";

        // Tạo một câu truy vấn được chuẩn bị với các tham số ràng buộc
        $stmt = $conn->prepare($sql);

        // Liên kết các giá trị của mảng sản phẩm với các tham số ràng buộc
        foreach ($product_ids as $key => $product_id) {
            $stmt->bindValue($key + 1, $product_id);
        }

        // Thực thi câu truy vấn
        $stmt->execute();

        // Kiểm tra xem có kết quả trả về hay không
        if ($stmt->rowCount() > 0) {
            echo '<div class="container">
                    <h2 class="text-success my-3 text-center">Thông tin giỏ hàng </h2>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>';
            
            $total_price = 0; // Biến tổng giá trị giỏ hàng
            $stt = 1; // Biến đếm số thứ tự sản phẩm
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Lấy thông tin sản phẩm từ kết quả truy vấn
                $product_id = $row['MaSanPham'];
                $product_name = $row['TenSanPham'];
                $product_price = $row['Gia'];
                $product_image = $row['URLHinhAnh'];
                $quantity = $_SESSION['cart'][$product_id]; // Số lượng sản phẩm trong giỏ hàng

                // Tính tổng giá của sản phẩm (giá x số lượng)
                $subtotal_price = $product_price * $quantity;
                $total_price += $subtotal_price;

                // Hiển thị thông tin sản phẩm trong bảng
                echo "<tr>
                        <td>$stt</td>
                        <td><img src='../../Img/$product_image' style='max-width: 100px; max-height: 100px;' alt='$product_name'></td>
                        <td>$product_name</td>
                        <td>$product_price Đ</td>
                        <td><input type='number' min='1' value='$quantity' data-product-id='$product_id' data-price='$product_price' class='quantity-input'></td>
                        <td class='subtotal-price' data-price-per-unit='$product_price'>$subtotal_price Đ</td>
                        <td><a href='DeleteProduct.php?id=$product_id' class='btn btn-danger'><i class='fas fa-trash-alt'></i></a></td>
                      </tr>";
                $stt++; // Tăng số thứ tự sản phẩm lên mỗi lần lặp
                
            }
          
            echo "<tr>
                    <td colspan='5' class='text-end fw-bold'>Tổng tiền:</td>
                    <td class='fw-bold' id='total-price'>$total_price VNĐ</td>
                    <td colspan='2'></td> <!-- Thêm cột trống để giữ cấu trúc của bảng -->
                  </tr>
                </tbody>
              </table>
            </div>

            <div class='text-center'>
                <a href='/LTMNM_DeTai1/View/User/Product/Index1.php' class='btn btn-warning'>Tiếp tục mua hàng</a>
                <a href='#' id='order-btn' class='btn btn-success ms-3'>Đặt hàng</a>
            </div>
            <!-- Form đặt hàng -->
           
                <div id='order-form' style='display: none;'>
				<h2 class='text-success my-3 text-center'>Thông tin đặt hàng </h2>
				<form method='post' action=''>

					<div class='mb-3'>
						<label for='name' class='form-label'>Họ và tên:</label>
				 <input type='text' class='form-control' id='name' name='name' value='" . htmlspecialchars($row4['HoTen']) . "' required>
					</div>
					<div class='mb-3'>
						<label for='phone' class='form-label'>Số điện thoại:</label>
						<input type='text' class='form-control' id='phone' name='phone' value='" . htmlspecialchars($row4['SoDienThoai']) . "'required>
					</div>
					<div class='mb-3'>
						<label for='address' class='form-label'>Địa chỉ:</label>
						<input type='text' class='form-control' id='address' name='address' value='" . htmlspecialchars($row4['DiaChi']) . "'required>
					</div>
					<div class='mb-3'>
						<label for='email' class='form-label'>Địa chỉ email:</label>
						<input type='email' class='form-control' id='email' name='email' value='" . htmlspecialchars($row4['Email']) . "'required>
					</div>
					<div class='mb-3'>
						<label for='payment_method' class='form-label'>Phương thức thanh toán:</label>
						<select class='form-select' id='payment_method' name='payment_method' required>
							<option value='COD'>Thanh toán khi nhận hàng (COD)</option>
							<option value='Online'>Thanh toán trực tuyến</option>
						</select>
					</div>
					<button type='submit' class='btn btn-primary'>Đặt hàng</button>
				</form>
            </div>


			 <script>
                // Hiển thị form đặt hàng khi nhấn nút 'Đặt hàng'
                document.getElementById('order-btn').addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ a
                    document.getElementById('order-form').style.display = 'block'; // Hiển thị form đặt hàng
                });

                // Cập nhật tổng giá khi thay đổi số lượng
                document.querySelectorAll('.quantity-input').forEach(function(input) {
                    input.addEventListener('change', function() {
                        var productId = this.getAttribute('data-product-id');
                        var quantity = this.value;
                        var pricePerUnit = parseFloat(this.getAttribute('data-price'));
                        var priceElement = this.closest('tr').querySelector('.subtotal-price');
                        var newSubtotal = quantity * pricePerUnit;
                        priceElement.textContent = newSubtotal.toLocaleString('vi-VN') + ' Đ';
                        
                        // Cập nhật tổng giá trị giỏ hàng
                        updateTotalPrice();
                    });
                });

                function updateTotalPrice() {
                    var totalPrice = 0;
                    document.querySelectorAll('.subtotal-price').forEach(function(priceElement) {
                        var subtotal = parseFloat(priceElement.textContent.replace(/[^\d]/g, ''));
                        totalPrice += subtotal;
                    });
                    document.getElementById('total-price').textContent = totalPrice.toLocaleString('vi-VN') + ' VNĐ';
                }
            </script>
		</div>";
		} else {
			echo '<div class="container"><p class="text-center">Giỏ hàng của bạn hiện đang trống.</p></div>';
		}
	} else {
		echo '<div class="container"><p class="text-center">Giỏ hàng của bạn hiện đang trống.</p></div>';
	}
}


include '../Footer.php';
?>


