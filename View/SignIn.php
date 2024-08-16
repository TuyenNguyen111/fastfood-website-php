<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    include("../Database/Connect.php");

    $sql3 = "SELECT MatKhau FROM nguoidung WHERE TenDangNhap = :username";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bindParam(':username', $username);
    $stmt3->execute();
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

    if ($row3) {
        $hashed_password = $row3['MatKhau'];
        if (password_verify($password, $hashed_password)) {
            $sql = "SELECT * FROM nguoidung WHERE TenDangNhap = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['user_id'] = $user['MaNguoiDung'];
                $_SESSION['username'] = $user['TenDangNhap'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: /LTMNM_DeTai1/View/Admin/Product/Index1.php");
                } else {
                    header("Location: /LTMNM_DeTai1/View/HomePage.php");
                }
                exit();
            } else {
                $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        } else {
            $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }

    $conn = null;
}
include 'Header.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Đăng nhập</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<h2 class="text-primary fs-1 text-center mt-5">Đăng nhập</h2>
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
<?php endif; ?>
<form action="SignIn.php" method="post" class="d-flex border flex-column p-5">
  <div class="d-flex col-7 mx-auto p-3">
    <label for="username" class="col-2">Tên đăng nhập</label>
    <input type="text" id="username" name="username" required class="form-control col-4" />
  </div>
  <div class="d-flex col-7 mx-auto p-3">
    <label class="col-2" for="password">Mật khẩu</label>
    <input type="password" id="password" name="password" required class="form-control col-4" />
  </div>
  <div class="mx-auto">Bạn chưa có tài khoản? <a href="/LTMNM_DeTai1/View/Register.php">Đăng kí</a></div>
  <div class="mx-auto"><a href="ForgotPassword.php">Quên mật khẩu?</a></div>
  <input class="btn-success col-5 mx-auto p-2 mt-3" type="submit" value="Đăng nhập">
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<?php include 'Footer.php'; ?>
