<?php
session_start();
include("../../../DataBase/Connect.php");

// Khai báo biến sort_condition để lưu trữ điều kiện sắp xếp
$sort_condition = "";

// Xử lý chức năng lọc theo giá
if(isset($_GET['price_range'])) {
    $price_range = $_GET['price_range'];
    switch($price_range) {
        case '1':
            $price_condition = "AND Gia BETWEEN 20000 AND 30000";
            break;
        case '2':
            $price_condition = "AND Gia BETWEEN 31000 AND 50000";
            break;
        case '3':
            $price_condition = "AND Gia BETWEEN 51000 AND 100000";
            break;
        case '4':
            $price_condition = "AND Gia > 100000";
            break;
        default:
            $price_condition = "";
            break;
    }
} else {
    $price_condition = "";
}

// Xử lý chức năng lọc theo món
if(isset($_GET['category'])) {
    $category = $_GET['category'];
    $category_condition = "AND MaLoai = '$category'";
} else {
    $category_condition = "";
}

// Xử lý tìm kiếm
$search_condition = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    $search_condition = "AND TenSanPham LIKE '%$search_term%'";
}

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="DinhDang.css">
    <style>
        /* CSS cho danh sách nhóm */
        .list-group {
            margin-bottom: 20px;
        }

        .list-group-item {
            background-color: #90D26D;; /* Xóa màu nền */
            border: none; /* Xóa đường viền */
            color: #0489DD; /* Màu chữ */
            font-size: 16px; /* Kích thước font chữ */
            font-weight: bold; /* Font chữ đậm */
            transition: background-color 0.3s; /* Hiệu ứng transition */
        }

        .list-group-item:hover {
            background-color: #f8f9fa; /* Màu nền khi di chuột vào */
        }
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 30px;
            font-size: 16px;
            border: none;
            border-radius: 3px;
            margin-left: 20px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;}

        .dropdown:hover .dropbtn {background-color: #3e8e41;}
        /* CSS cho sidenav */
        .sidenav {
            height: 100%;
            width: 250px;
            position: absolute;
            z-index: 1;
            top: 0;
            left: -250px;
            overflow-x: hidden;
            transition: 0.5s; /* Hiệu ứng transition */
        }

        .sidenav.show {
            left: 0;
            margin-top: 170px;
        }

        .sidenav a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 16px;
            color: #fff;
            display: block;
            transition: 0.3s; /* Hiệu ứng transition */
        }

        .sidenav a:hover {
            background-color: #333; /* Màu nền khi di chuột vào */
        }

        .sidenav strong {
            display: block;
            padding: 10px 15px;
            background-color: #ff5883;
            color: #fff;
            margin-bottom: 10px;
        }

        .sidenav strong a {
            color: #fff;
            text-decoration: none;
        }

        .sidenav strong a:hover {
            background-color: #ff376c; /* Màu nền khi di chuột vào */
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
            margin-left: 0; /* Đặt margin-left của main thành 0 ban đầu */
        }

        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }

        /* CSS cho thanh tìm kiếm */
        .search-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-input {
            width: 200px; /* Điều chỉnh chiều rộng của thanh tìm kiếm */
            margin-right: 10px;
        }
       
    </style>
    <script>
        // Function to display success message
        function displaySuccessMessage() {
            alert("Đã thêm sản phẩm vào giỏ hàng thành công.");
        }
        // Function to display login message
        function displayLoginMessage() {
            alert("Vui lòng đăng nhập để mua ngay.");
        }
        // Function to toggle category list visibility
        function toggleCategoryList() {
            var categoryList = document.getElementById("categoryList");
            if (categoryList.style.display === "none" || categoryList.style.display === "") {
                categoryList.style.display = "block";
            } else {
                categoryList.style.display = "none";
            }
        }

       function togglePriceOptions() {
            var category = "<?php echo isset($_GET['category']) ? urlencode($_GET['category']) : ''; ?>";
            var priceOptions = document.getElementById("priceOptions");
            if (priceOptions.style.display === "none" || priceOptions.style.display === "") {
                priceOptions.style.display = "block";
                // Cập nhật URL cho các liên kết phạm vi giá
                var links = priceOptions.getElementsByTagName("a");
                for (var i = 0; i < links.length; i++) {
                    var href = links[i].getAttribute("href");
                    // Kiểm tra xem đã có tham số "category" trong URL chưa
                    if (category !== '') {
                        // Nếu đã có tham số "category", thêm tham số "price_range" vào URL
                        if (href.indexOf("?") !== -1) {
                            links[i].setAttribute("href", href + "&category=" + category);
                        } else {
                            links[i].setAttribute("href", href + "?category=" + category);
                        }
                    }
                }
            } else {
                priceOptions.style.display = "none";
            }
        }

        // Set a JavaScript variable for login status
        var isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
    </script>
</head>
<body>
<?php include '../../Header.php'; ?>
<div>
    <div id="main">
        <div class="container" style="margin-top:auto">
            <div id="mySidenav" class="sidenav">
                <div class="list-group">
                    <?php
                    // Lấy danh sách loại món ăn từ CSDL
                    $sql = "SELECT MaLoai, TenLoai FROM loaisanpham";
                    $sta = $conn->prepare($sql);
                    $sta->execute();
                    if ($sta->rowCount() > 0) {
                        $loaisanpham = $sta->fetchAll(PDO::FETCH_OBJ);
                        foreach($loaisanpham as $kay=>$loai) {
                            ?>
                            <!-- Hiển thị mỗi loại món ăn dưới dạng list-group-item -->
                            <a style="color: #0489DD" href="?category=<?php echo urlencode($loai->MaLoai); ?>" class="list-group-item list-group-item-action"><?php echo $loai->TenLoai;?></a>
                            <?php
                        }
                    }
                    ?>
                    <strong><a style="color: #0489DD" href="?show_all=true" class="list-group-item list-group-item-action">Tất cả sản phẩm</a></strong>
                </div>
            </div>
            
            <div>
            <span style="font-size:30px;cursor:pointer" onclick="toggleCategoryList()">&#9776; Menu</span>
            <!-- Nút mở/dóng phần chọn theo giá -->
            <div class="dropdown">
            <button class="dropbtn" onclick="togglePriceOptions()">Chọn theo giá</button>
            <!-- Phần chọn theo giá -->
            <div class="dropdown-content" id="priceOptions" style="display: none;">
                <strong><a href="?price_range=1" class="list-group-item list-group-item-action">20,000đ - 30,000đ</a></strong>
                <strong><a href="?price_range=2" class="list-group-item list-group-item-action">31,000đ - 50,000đ</a></strong>
                <strong><a href="?price_range=3" class="list-group-item list-group-item-action">51,000đ - 100,000đ</a></strong>
                <strong><a href="?price_range=4" class="list-group-item list-group-item-action">Trên 100,000đ</a></strong>
            </div>
            </div>
            </div>
            
            <?php
            // Kiểm tra kết nối
            if ($conn) {
                // Số lượng bản ghi trên mỗi trang
                $display = 8;
                // Trang hiện tại
                $curr_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                // Vị trí bắt đầu lấy bản ghi
                $position = ($curr_page - 1) * $display;

                // Câu truy vấn lấy dữ liệu với phân trang và điều kiện tìm kiếm
                $sql = "SELECT * FROM sanpham WHERE 1 $price_condition $category_condition $search_condition $sort_condition LIMIT $position, $display";
                $result = $conn->query($sql);

                // Hiển thị sản phẩm
                if ($result && $result->rowCount() > 0) {
                    ?>
                    <h2 class="fw-bold text-center text-success">Danh sách sản phẩm</h2>
                    <div class="d-flex flex-wrap justify-content-center">
                        <?php foreach ($result as $row): ?>
                            <div class="col">
                                <div class="card">
                                    <a href="/LTMNM_DeTai1/View/User/Product/ProductDetail.php?id=<?php echo $row['MaSanPham']; ?>">
                                        <img src="../../../Img/<?php echo $row['URLHinhAnh']?>" class="card-img-top" alt="<?php echo $row['TenSanPham']?>">
                                    </a>

                                    <div class="card-body">
                                        <center>
                                            <h5 class="card-title"><?php echo $row['TenSanPham']?></h5>
                                            <p class="card-text fs-3 text-danger fw-bold"><?php echo $row['Gia']?> Đ</p>
                                            <form method="post" action="">
                                                <input type="hidden" name="product_id" value="<?php echo $row['MaSanPham']; ?>">

                                                <?php if (isset($_SESSION['username'])) { ?>
                                                    <a href="/LTMNM_DeTai1/View/User/Product/BuyNow.php?id=<?php echo $row['MaSanPham']; ?>" name="add_to_cart"  class="btn btn-success btn-lg">Mua ngay</a>
                                                    <button type="submit" name="add_to_cart" value="add_to_cart" class="btn btn-info btn-lg" onclick="displaySuccessMessage()"><i class="fa-solid fa-cart-plus"></i></button>
                                                <?php } else { ?>
                                                    <a href="/LTMNM_DeTai1/View/SignIn.php" name="add_to_cart"  class="btn btn-success btn-lg" onclick="displayLoginMessage()">Mua ngay</a>
                                                    <a href="/LTMNM_DeTai1/View/SignIn.php" name="add_to_cart"  class="btn btn-info btn-lg" onclick="displayLoginMessage()"><i class="fa-solid fa-cart-plus"></i></a>
                                                <?php } ?>

                                                
                                            </form>
                                        </center>
                                    </div>
                                </div>
                                <br/>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                } else {
                    // Không có sản phẩm nào trong CSDL
                    echo "<p class='text-center' style='height:400px'>Không có sản phẩm để hiển thị.</p>";
                }

                // Tính toán số trang và hiển thị phân trang nếu có dữ liệu
                $sql_count = "SELECT COUNT(*) FROM sanpham WHERE 1 $price_condition $category_condition $search_condition";
                $stmt = $conn->query($sql_count);
                $total_rows = $stmt->fetchColumn();
                $total_pages = ceil($total_rows / $display);

                if ($total_pages > 1) {
                    echo "<div class='Pagination'>";
                    if ($curr_page > 1) {
                        echo "<a href='?page=" . ($curr_page - 1) . "'>&lt; Trang trước</a>";
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $curr_page) {
                            echo "<a class='current'>$i</a>";
                        } else {
                            echo "<a href='?page=$i'>$i</a>";
                        }
                    }
                    if ($curr_page < $total_pages) {
                        echo "<a href='?page=" . ($curr_page + 1) . "'>Trang sau &gt;</a>";
                    }
                    echo "</div>";
                }
            } else {
                // Kết nối CSDL không thành công
                echo "Kết nối CSDL không thành công.";
            }
            ?>
        </div>
    </div>
</div>
<?php include '../../Footer.php'; ?>
</body>
</html>
<script>
    function toggleCategoryList() {
        var categoryList = document.getElementById("mySidenav");
        var mainContent = document.getElementById("main");
        if (categoryList.classList.contains('show')) {
            categoryList.classList.remove('show');
            mainContent.style.marginLeft= "0";
        } else {
            categoryList.classList.add('show');
            mainContent.style.marginLeft = "250px";
        }
    }

    function displaySuccessMessage() {
        if (isLoggedIn) {
            alert("Đã thêm sản phẩm vào giỏ hàng thành công.");
        } else {
            displayLoginMessage();
        }
    }
</script>