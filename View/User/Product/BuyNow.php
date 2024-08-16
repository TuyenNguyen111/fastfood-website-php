
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../Header.php';
// Gọi kết nối
include("../../../DataBase/Connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include '../vendor/PHPMailer/src/Exception.php';
include '../vendor/PHPMailer/src/PHPMailer.php';
include '../vendor/PHPMailer/src/SMTP.php';

// Kiểm tra kết nối
if ($conn) {

    $ten=$_SESSION["username"];
    $sql4="select * from nguoidung where tendangnhap='$ten' limit 1";
    $result4=$conn->query($sql4);
    $row4=$result4->fetch();
     
    // Kiểm tra xem tham số ID sản phẩm đã được thiết lập trong URL không
    if (isset($_GET['id'])) {
        // Lấy ID sản phẩm từ URL và loại bỏ các ký tự đặc biệt
        $product_id = htmlspecialchars($_GET['id']);
         $querySelect="select * from phanhoi where MaSanPham='$product_id' order by MaPhanHoi desc limit 3";
        $resultSe=$conn->query($querySelect);
        // Truy vấn SQL sử dụng prepared statement để tránh lỗ hổng bảo mật SQL Injection
        $sql = "SELECT * FROM sanpham WHERE MaSanPham = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        // Kiểm tra xem có sản phẩm nào được trả về từ cơ sở dữ liệu không
        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
?>
            <div class="container" style="padding:40px">
                <h2 class="fs-1 text-success fw-bold text-center my-5">Thông tin đặt hàng</h2>
                <div class="product-custom product-single" itemtype="https://schema.org/Product">
                    <div class="row mb-4s">
                        <div class="col-lg-5" itemprop="image">
                            <div class="swiper-slide swiper-slide-duplicate field-img position-relative swiper-slide-prev" data-swiper-slide-index="3" style="width: 90%">
                                <img src="../../../Img/<?php echo $product['URLHinhAnh']; ?>" alt="<?php echo $product['TenSanPham']; ?>" sizes="(max-width: 480px) 100vw, (max-width: 1200px) 30vw, 360px" style="aspect-ratio: 16 / 16; width: 70%; height: auto; display: block; pointer-events: none;">
                            </div>
                        </div>
                        <div class="col-lg-7 portal-wrap">
                            <div id="portal" class="portal"></div>
                            <div class="info">
                                <button class="btn btn-outline-light btn-md p-1 float-end ms-3" title="Chia sẻ sản phẩm"><i class="icons icon-share"></i></button>
                                <div class="d-flex justify-content-between">
                                    <label>Sản phẩm :</label>
                                    <h2 class="field-name fontsize-24 fw-bold text-danger" itemprop="name"><?php echo $product['TenSanPham']; ?></h2>
                                    <button type="submit" name="add_to_cart" value="add_to_cart" class="btn btn-info btn-lg " onclick="displaySuccessMessage()"><i class="fa-solid fa-cart-plus"></i></button>
                                </div>
                                <div class="field-score fontsize-16 txt-dark mb-4s">
                                    <div id="order-form" style="">
                                        <h2 class="text-info my-3 text-center">Thông tin khách hàng </h2>
                                        <form method="post" action="">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Họ và tên:</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row4['HoTen']; ?> "required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Số điện thoại:</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row4['SoDienThoai'];?>"required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Địa chỉ:</label>
                                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row4['DiaChi'];?>" required>
                                            </div>
                                             <div class='mb-3'>
                                                <label for='email' class='form-label'>Địa chỉ email:</label>
                                                <input type='email' class='form-control' id='email' name='email' value="<?php echo $row4['Email'];?>"required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="payment_method" class="form-label">Phương thức thanh toán:</label>
                                                <select class="form-select" id="payment_method" name="payment_method" required>
                                                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                                                    <option value="Online">Thanh toán trực tuyến</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="note" class="form-label">Ghi chú :</label>
                                                <input type="text" class="form-control" id="note" name="note">
                                            </div>
                                            <div class="mb-3 d-flex">
                                                <label for="address" class="form-label mx-3">Số lượng :</label>
                                                <button type="button" class="btn btn-success" onclick="decreaseQuantity()">-</button>
                                                <input type="number" class="mx-3" readonly id="quantity" name="quantity" value="1" min="1" required>
                                                <button type="button" class="btn btn-success" onclick="increaseQuantity()">+</button>
                                            </div>
                                            <div class="d-flex">
                                                <label class="fs-3 text-danger fw-bold pt-3 mx-3">Tổng tiền : </label>
                                                <input type="text" readonly class="field-price fw-bold" id="price" name="price" style="font-size:40px ;color: blue ;border:none ;width: 200px;"  value="<?php echo $product['Gia']?>">
                                                <p class="pt-3 fs-3 text-danger fw-bold">Đ</p>
                                            </div>
                                            <button type="submit" class="btn btn-success">Đặt hàng</button>
                                        </form>
                                    </div> <!-- Kết thúc form đặt hàng -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="customer-review" style="margin-top:200px">
                <h5 class="mb-5">Đánh giá của khách hàng</h5>
                <hr>
               <?php foreach ($resultSe as $rowSe): 

                  $querySelectnd = "select HoTen from nguoidung where MaNguoiDung='{$rowSe['MaNguoiDung']}'";
                 $resultSend=$conn->query($querySelectnd);
                 $rowSend=$resultSend->fetch();
                ?>
                  
                
                
                    <div>
                        <p><?php echo $rowSend['HoTen']?></p>
                        <div class="rating mt-0">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                </div>
                        <p class="ms-5 mt-3"><?php echo $rowSe['NoiDung']?></p>
                    </div>
                    <hr>
                <br />
                
                <?php endforeach; ?>
                
                <form method="post" action="Comment.php?masp=<?php echo $product['MaSanPham'];?>">
                    <textarea class="review-input col-5" id="review-input" name="review-input" placeholder="Nhập lời nhận xét của bạn"></textarea>
                    <br>
                    <button class="submit-btn" type="submit" onclick="submitReview()">Gửi nhận xét</button>
                </form>
            </div>
            </div>
            <script>
                var initialPrice = <?php echo $product['Gia']; ?>;

                function increaseQuantity() {
                    var input = document.getElementById("quantity");
                    var price = document.getElementById("price");
                    var newValue = parseInt(input.value) + 1;

                    // Update quantity
                    input.value = newValue;

                   
// Calculate new price
                    var newPrice = initialPrice * newValue;

                    // Update price
                    price.value = newPrice;
                    price.textContent = newPrice;
                }

                function decreaseQuantity() {
                    var input = document.getElementById("quantity");
                    var price = document.getElementById("price");

                    var newValue = parseInt(input.value) - 1;

                    // Ensure quantity doesn't go below 1
                    if (newValue < 1) {
                        newValue = 1;
                    }

                    // Update quantity
                    input.value = newValue;

                    // Calculate new price
                    var newPrice = initialPrice * newValue;

                    // Update price
                    price.value = newPrice;
                    price.textContent = newPrice;
                }
            </script>
<?php
            // Xử lý dữ liệu đặt hàng và gửi email thông báo
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Lấy dữ liệu từ form
                $name = htmlspecialchars($_POST['name']);
                $phone = htmlspecialchars($_POST['phone']);
                $address = htmlspecialchars($_POST['address']);
                $email = htmlspecialchars($_POST['email']);
                $payment_method = htmlspecialchars($_POST['payment_method']);
                $note = htmlspecialchars($_POST['note']);
                $quantity = htmlspecialchars($_POST['quantity']);
                $total_price = htmlspecialchars($_POST['price']);
                
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
    $sql_insert_order_detail = "INSERT INTO chitietdonhang (MaDon, MaSanPham, SoLuong, Gia) 
                                VALUES (?, ?, ?, ?)";
    $stmt_insert_order_detail = $conn->prepare($sql_insert_order_detail);
    $stmt_insert_order_detail->execute([$order_id, $product_id, $quantity, $total_price]);

                    // Gửi email thông báo
                    $mail = new PHPMailer(true);
                    
                    try {
                        // Cấu hình SMTP
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
                    
                        // Thiết lập tiêu đề và nội dung email
                        $mail->isHTML(true);
                        $mail->Subject = '=?UTF-8?B?' . base64_encode('Bạn đã đặt hàng thành công!') . '?=';
                        $mail->Body = "Chào $name,<br><br>Thông tin đơn hàng:<br>Tên sản phẩm: {$product['TenSanPham']}<br>Số lượng: $quantity<br>Tổng tiền: $total_price<br><br>Cảm ơn bạn đã mua hàng của chúng tôi.";
                    
                        // Gửi email
                        $mail->send();
                        echo '<script>alert("Đã đặt hàng thành công, vui lòng kiểm tra email để xem thông tin đơn hàng");</script>'; // Hiển thị thông báo JavaScript
                        
                        // Commit transaction
                        $conn->commit();
                    } catch (Exception $e) {
                        // Nếu có lỗi, rollback transaction
                        $conn->rollback();
                        echo "Gửi email thông báo thất bại: " . $mail->ErrorInfo;
                    }
                } catch (Exception $e) {
                    // Nếu có lỗi trong quá trình xử lý đặt hàng, rollback transaction
                    $conn->rollback();
                    echo "Đặt hàng thất bại: " . $e->getMessage();
                }
            }
?>
<?php
        } else {
            // Không tìm thấy sản phẩm
            echo "<p>Sản phẩm không tồn tại.</p>";
        }
    } else {
        // Nếu không có tham số ID sản phẩm trong URL
        echo "<p>Tham số ID sản phẩm không được thiết lập.</p>";
    }
} else {
    // Kết nối CSDL không thành công
    echo "Kết nối CSDL không thành công.";
}
?>
<?php include '../../Footer.php'; ?>




