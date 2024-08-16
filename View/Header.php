<?php
// Kiểm tra xem session đã được khởi tạo chưa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/f98b8fd209.js" crossorigin="anonymous"></script>
    <style>
        .nav-item.active {
            position: relative;
            transform: scale(1.1);
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
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

    .hidden {
      display: none;
    }
  
        .nav-item.active:hover::before {
            transform: scaleX(1);
        }

        .review-output {
            margin-top: 10px;
            font-size: 18px;
        }

        .highlight-item {
            background-color: #f8f9fa;
        }

        .highlight-item:hover {
            background-color: #e9ecef;
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

        .field-validation-error {
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
         .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body>
<div>
    <a href="#" class="header text-decoration-none">
        <img src="https://uploads.turbologo.com/uploads/icon/preview_image/6134678/6482176-84.png" width="80">
        <h1 class="mb-0" style="font-size: 40px; color: #ff4d6d; font-weight: bold;">Cake DouF</h1>
    </a>
    <?php if (isset($_SESSION['username'])) {
        $role = $_SESSION['role'];
    } ?>
    <nav class="navbar navbar-expand-sm sticky-top" style="background-color: #ffe0e9">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item active">
                        <a class="nav-link px-3" href="/LTMNM_DeTai1/View/HomePage.php">Trang chủ</a>
                    </li>
                    &nbsp; &nbsp;
                    <li class="nav-item active">
                       
                        <?php
                        // Kiểm tra xem người dùng đã đăng nhập hay chưa
                        if (isset($_SESSION['user_id'])) {
                            // Nếu đã đăng nhập, kiểm tra vai trò của người dùng
                            if ($role == "admin") {

                                echo "<div class='dropdown'>
                                <a class='nav-link px-3' id='toggleButton' href='#'>Tác vụ</a>
                                <div class='dropdown-menu' style='background-color:#ffe0e9'>
                                    <a class='dropdown-item' href='/LTMNM_DeTai1/View/Admin/Category/Index1.php'>Loại sản phẩm</a>
                                    <a class='dropdown-item' href='/LTMNM_DeTai1/View/Admin/Product/Index1.php'>Sản phẩm</a>
                                     <a class='dropdown-item' href='/LTMNM_DeTai1/View/Admin/Order/Index1.php'>Đơn hàng</a>
                               
                                ";
                            } else {
                                // Nếu là người dùng thông thường, đưa họ đến trang sản phẩm của người dùng
                               echo "<a class='nav-link px-3' href='/LTMNM_DeTai1/View/User/Product/Index1.php'> Sản phẩm </a>";
                       
                            }
                         }else {
                            // Nếu chưa đăng nhập, vẫn cho phép truy cập vào trang sản phẩm của người dùng
                           echo " <a class='nav-link px-3' href=/LTMNM_DeTai1/View/User/Product/Index1.php> Sản phẩm</a>";
                        
                        }
                        ?>
                       
                    </li>

                     <?php  if (isset($_SESSION['user_id']))
                            {if ($role == "user")
                     {
                        echo"
                        <li class='nav-item active'>
                        <a class='nav-link px-3' href='/LTMNM_DeTai1/View/User/Order/Index1.php'>Đơn hàng của bạn</a>
                        
                    </li>";}}   
                     ?>
                    <li class="nav-item active">
                        <a class="nav-link px-3" href="/LTMNM_DeTai1/View/Contact.php">Liên hệ</a>
                    </li>
                </ul>
                 <!-- Biểu mẫu tìm kiếm -->
                <form class="d-flex me-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                    <input class="form-control shadow-none" type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Tìm kiếm sản phẩm">
                    <button style="background: #ff79a1" class="d-flex align-items-center justify-content-between btn text-white px-3" type="submit">
                        <i class='bx bx-search fs-6'></i>
                    </button>
                </form>
                <?php if (isset($_SESSION['username'])) { ?>
                    <a href="/LTMNM_DeTai1/View/User/Cart.php">
                        <i class='bx bx-shopping-bag' style="font-size:40px"></i>
                    </a>
                <?php } else { ?>
                    <a href="/LTMNM_DeTai1/View/SignIn.php" onclick="displayErrorMessage()">
                        <i class='bx bx-shopping-bag' style="font-size:40px"></i>
                    </a>
                <?php } ?>
                    <ul class="nav navbar-nav navbar-right">
                    <li class="d-flex flex-column ms-3"><i class="fa-solid fa-user fs-3 ps-4"></i>
                        <?php if (isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];
                        ?>
                             <div class="dropdown">
                                <a class="text-info fw-bold" id="toggleButton" href="#"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                                <div class="dropdown-menu" style="background-color:#ffe0e9">
                                    <a class="dropdown-item" href="/LTMNM_DeTai1/View/Logout.php">Đăng xuất</a>
                                    <a class="dropdown-item" href="/LTMNM_DeTai1/View/ChangePassword.php">Đổi mật khẩu</a>
                                </div>
                            </div>
                        <?php } else { ?>
                            <a class="fw-bold" style="text-decoration: none;" href="/LTMNM_DeTai1/View/SignIn.php"> Đăng nhập</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>


<script>
    function displaySuccessMessage() {
        alert("Vui lòng đăng nhập để xem giỏ hàng.");
    }
</script>

   <script>
    document.getElementById("toggleButton").addEventListener("click", function() {
      var button = document.getElementById("hiddenButton");
      button.classList.toggle("hidden");
    });
  </script>
</body>
</html>
