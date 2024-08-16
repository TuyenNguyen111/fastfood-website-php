<?php
	session_start();
	// Kiểm tra xử lý thêm sản phẩm vào giỏ hàng
	if(isset($_POST['add_to_cart'])) {
		// Lấy ID sản phẩm từ form
		$product_id = $_POST['product_id'];
		$quantity = 1;
	
		// Thêm sản phẩm vào giỏ hàng trong session
		$_SESSION['cart'][$product_id] = $quantity;
	
		// Kiểm tra xem nút được nhấn là nút "Mua ngay" hay "Thêm vào giỏ hàng"
		if($_POST['add_to_cart'] == 'buy_now') {
			// Chuyển hướng đến trang Cart.php sau khi thêm sản phẩm vào giỏ hàng
			header('Location: /LTMNM_DeTai1/LTMNM_DeTai1/View/User/Cart.php');
			exit(); // Đảm bảo không có mã HTML hoặc lệnh nào được thực thi sau lệnh chuyển hướng
		}
		// Đặt thông báo thành công vào session
		$_SESSION['cart_success'] = true;
	}
        // Xóa thông báo sau khi đã hiển thị
        unset($_SESSION['cart_success']);
?>
<?php
include '../../Header.php';
// Gọi kết nối
include("../../../DataBase/Connect.php");

// Kiểm tra kết nối
if ($conn) {
    // Kiểm tra xem tham số ID sản phẩm đã được thiết lập trong URL không
    if (isset($_GET['id'])) {
        // Lấy ID sản phẩm từ URL và loại bỏ các ký tự đặc biệt
        $product_id = htmlspecialchars($_GET['id']);
        
        // Truy vấn SQL sử dụng prepared statement để tránh lỗ hổng bảo mật SQL Injection
        $sql = "SELECT * FROM sanpham WHERE MaSanPham = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        // Kiểm tra xem có sản phẩm nào được trả về từ cơ sở dữ liệu không
        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<script>
        // Function to display success message
        function    displaySuccessMessage() {
            var user=document.getElementById('toggleButton');
            if(user.value.length!=0)
            {

            alert("Đã thêm sản phẩm vào giỏ hàng thành công.");
        }
        }
    </script>
            <div class="container" style="padding:40px">
    <div class="product-custom product-single" itemtype="https://schema.org/Product">
        <div class="row mb-4s">
            <div class="col-lg-5" itemprop="image">

                        <div class="swiper-slide swiper-slide-duplicate field-img position-relative swiper-slide-prev" data-swiper-slide-index="3" style="width: 90%">
                            <img src="../../../Img/<?php echo $product['URLHinhAnh']; ?>" alt="<?php echo $product['TenSanPham']; ?>" sizes="(max-width: 480px) 100vw, (max-width: 1200px) 30vw, 360px" style="aspect-ratio: 16 / 16; width: 100%; height: auto; display: block; pointer-events: none;">
                        </div>

            </div>
            <div class="col-lg-7 portal-wrap">
                <div id="portal" class="portal"></div>
                <div class="info">
                    <button class="btn btn-outline-light btn-md p-1 float-end ms-3" title="Chia sẻ sản phẩm"><i class="icons icon-share"></i></button>
                    <h2 class="field-name fontsize-24 fw-bold text-danger" itemprop="name"><?php echo $product['TenSanPham']; ?></h2>
                    <div class="field-score fontsize-16 txt-dark mb-4s">
                        <span class="lbl-rating">
                            <span class="icon w-20"></span>5.0|
                        </span>
                        <span><a href="#" class="btn-link">1<!-- --> <!-- -->Đánh giá</a></span>
                    </div>
                    <div class="field-price fw-bold" style="font-size:40px ;color: blue"><?php echo number_format($product['Gia'], 0, ',', '.'); ?>&nbsp;₫</div>
                    <div class="blk-cont-info mb-4s">
                        <div class="d-flex align-items-center mb-3s">
                            <h4 class="fontsize-16 mb-0">Mô tả </h4>
                        </div>
                        <div class="short-desc fontsize-14 mb-3 txt-grayer fs-3" itemprop="description">
                            <ul>
                                <?php echo $product['MoTa']; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="blk-actions mb-4s">
                        <div class="container">
                            <div class="row g-3">
                                <div class="col">
                                    <form method="post" action="">
                                        <input type="hidden" name="product_id" value="<?php echo $product['MaSanPham']; ?>">
                                       <a href="/LTMNM_DeTai1/View/User/Product/BuyNow.php?id=<?php echo $product['MaSanPham']; ?>" name="add_to_cart"  class="btn btn-success btn-lg">Mua ngay</a>
                                        <button type="submit" name="add_to_cart" value="add_to_cart" class="btn btn-info btn-lg " onclick="displaySuccessMessage()"><i class="fa-solid fa-cart-plus"></i></button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function updateQuantity(change) {
        var quantityInput = document.getElementById('quantity');
        var currentValue = parseInt(quantityInput.value);
        
        // Kiểm tra giá trị mới có nằm trong khoảng cho phép không
        var newValue = currentValue + change;
        if(newValue < 1 || newValue > 97) {
            return;
        }
        
        // Cập nhật giá trị mới cho input số lượng
        quantityInput.value = newValue;
    }
</script>



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