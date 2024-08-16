<?php
    
    session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS và Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Other styles -->
    <!-- Other meta tags, stylesheets, and scripts remain unchanged -->
</head>
	 <style>
        body{
            background-color: #90D26D;
        }
        .nav-item.active {
            position: relative;
            transform: scale(1.1);
            /* Thêm hiệu ứng mong muốn */
            transition: transform 0.3s ease;
        }

            .nav-item.active::before {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background-color: #ff79a1;
                /* Thêm hiệu ứng mong muốn */
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 0.3s ease;
            }

            .nav-item.active:hover::before {
                transform: scaleX(1);
            }
        .review-output {
            margin-top: 10px;
            font-size: 18px;
        }

        .highlight-item {
            background-color: #f8f9fa; /* Thay đổi màu nền */
        }

            .highlight-item:hover {
                background-color: #e9ecef; /* Hiệu ứng hover */
            }
        .highlight-card {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        .card-clickable {
            transition: transform 0.3s ease;
        }

            .card-clickable:hover {
                transform: scale(1.05);
            }
        .review-input {
            width: 800px;
            height: 50px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            resize: none;
        }

        .submit-btn {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .checked {
            color: orange;
        }


        .customer-review {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .review-text {
            font-style: italic;
            color: #555;
        }



        .field-validation-error{
            color: red;
            font-size: 12px;
        }
        .validation-summary-errors {
            color: red;
            font-size: 12px;
        }
        .pagination {
            --bs-pagination-padding-x: 0.75rem;
            --bs-pagination-padding-y: 0.375rem;
            --bs-pagination-font-size: 1rem;
            --bs-pagination-color: var(--bs-link-color);
            --bs-pagination-bg: var(--bs-body-bg);
            --bs-pagination-border-width: var(--bs-border-width);
            --bs-pagination-border-color: var(--bs-border-color);
            --bs-pagination-border-radius: var(--bs-border-radius);
            --bs-pagination-hover-color: var(--bs-link-hover-color);
            --bs-pagination-hover-bg: var(--bs-tertiary-bg);
            --bs-pagination-hover-border-color: var(--bs-border-color);
            --bs-pagination-focus-color: var(--bs-link-hover-color);
            --bs-pagination-focus-bg: var(--bs-secondary-bg);
            --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            --bs-pagination-active-color: #fff;
            --bs-pagination-active-bg: #FF79AC;
            --bs-pagination-active-border-color: #0d6efd;
            --bs-pagination-disabled-color: var(--bs-secondary-color);
            --bs-pagination-disabled-bg: var(--bs-secondary-bg);
            --bs-pagination-disabled-border-color: var(--bs-border-color);
            display: flex;
            padding-left: 0;
            list-style: none;
        }

        a {
            color: #000;
            text-decoration: none;
        }

        body {
            overflow-x: hidden;
        }

        .header {
            display: flex;
            align-items: center;
            padding: 10px;
            background-image: url("https://thuyduong2103td.github.io/thuyduong_g/banh.png");
            color: rgb(0, 0, 0);
            padding-left: 40px;
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }

    </style>
<body>
    <?php include 'Header.php';?>
        <div>
        <div>
        <div class="row">
            <div class="col-sm-4" style="padding: 30px;">
                <div class="p-3">
                    <h5 class="mb-4">
                        <img src="https://static.thenounproject.com/png/3030222-200.png" style="width: 10%; height:10%">
                        Các sản phẩm hot nhất
                    </h5>
    
                    <div class="mb-4">
                        <img src="https://statics.vincom.com.vn/xu-huong/chi_tiet_xu_huong/1/14-4/3/banh-mi.jpg" style="width: 100%; border-radius: 10px;">
                        <p class="text-muted">Bánh mì là đồ ăn nhanh truyền thống của người Việt. Món ăn này được dùng làm đồ ăn sáng hoặc xế chiều. Bánh mì có lớp vỏ ngoài xốp giòn, bên trong là phần nhân đầy đặn xá xíu, rau thơm, nộm, pate, thịt, dưa leo và thêm một ít nước sốt, tương ớt.</p>
                        <a href="/LTMNM_DeTai1/View/User/Product/Index1.php?category=003 "class="btn btn-success">Mua ngay</a>
                    </div>
                    <div>
                        <img src="https://statics.vincom.com.vn/xu-huong/chi_tiet_xu_huong/1/14-4/3/hamburger.jpg" style="width:100%; border-radius: 10px;">
                        <p class="text-muted">Hamburger là một thức ăn nhanh phổ biến ở Mỹ và một số quốc gia phương Tây. Món ăn này gồm có bánh mì tròn kẹp một lát thịt bò xay ở giữa, kèm cà chua, rau xà lách, phô mai và một ít nước sốt.</p>
                          <a href="/LTMNM_DeTai1/View/User/Product/Index1.php?category=001"class="btn btn-success">Mua ngay</a>
                    </div>
                </div>
                <hr class="d-sm-none">
            </div>
            <div class="col-sm-8">
                <div class="p-3">
                    <div style="height: 392px" id="demo" class="carousel slide" data-bs-ride="carousel">
                        <!-- Indicators/dots -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                        </div>
    
                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner h-100">
                            <div class="carousel-item active h-100">
                                <img src="https://images.pexels.com/photos/7886593/pexels-photo-7886593.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Los Angeles" class="d-block h-100 object-fit-cover" style="width:100%; border-radius: 10px;">
                                <div class="carousel-caption">
                                    <p>Chúng ta sẽ có những khoảnh khắc tuyệt vời</p>
                                </div>
                            </div>
                            <div class="carousel-item h-100">
                                <img src="https://cdn.nhathuoclongchau.com.vn/unsafe/800x0/filters:quality(95)/https://cms-prod.s3-sgn09.fptcloud.com/tac_hai_cua_thuc_an_nhanh_khon_luong_hon_ban_nghi_day1_73d0dba74e.jpeg" class="d-block h-100 object-fit-cover" style="width: 100%; border-radius: 10px;">
                                <div class="carousel-caption">
                                    <p>Cảm ơn vì các bạn!</p>
                                </div>
                            </div>
                            <div class="carousel-item h-100">
                                <img src="https://mqflavor.com/wp-content/uploads/2020/11/thi-truong-thuc-an-nhanh-viet-nam-su-phat-trien-khong-ngung-nghi.jpg" alt="New York" class="d-block h-100 object-fit-cover back" style="width: 100%; border-radius: 10px;">
                                <div class="carousel-caption">
                                    <p>Yêu các bạn rất nhiều!</p>
                                </div>
                            </div>
                        </div>
    
                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
    
                    <div class="container-fluid mt-3">
            <hr color="#d81159" size="6px" align="left" />
            <div class="customer-review">
                <h5>Đánh giá của khách hàng</h5>
                <div class="rating">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                </div>
                <br />
                <form>
                    <textarea class="review-input" id="review-input" placeholder="Nhập lời nhận xét của bạn"></textarea>
                    <br>
                    <button class="submit-btn" type="button" onclick="submitReview()">Gửi nhận xét</button>
                </form>
                <div class="review-output" id="review-output"></div>
    
                <?php
                // PHP logic for handling the submitted review
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $reviewInput = $_POST["review-input"];
                    // Process and save the review as needed
                }
                ?>
            </div>
                </div>
            </div>
        </div>
    </div>

        </div>
      <?php include 'Footer.php';?>

</body>
</html>
