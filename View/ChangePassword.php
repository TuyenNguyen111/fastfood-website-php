<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: SignIn.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    } else {
        include("../Database/Connect.php");
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT MatKhau FROM nguoidung WHERE MaNguoiDung = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($current_password, $user['MatKhau'])) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update_sql = "UPDATE nguoidung SET MatKhau = :new_password WHERE MaNguoiDung = :user_id";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bindParam(':new_password', $hashed_new_password);
            $update_stmt->bindParam(':user_id', $user_id);
            if ($update_stmt->execute()) {
                $success_message = "Mật khẩu đã được thay đổi thành công.";
            } else {
                $error_message = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        } else {
            $error_message = "Mật khẩu hiện tại không đúng.";
        }
        $conn = null;
    }
}
 include 'Header.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Đổi mật khẩu</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<h2 class="text-primary fs-1 text-center mt-5">Đổi mật khẩu</h2>
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
<?php elseif (isset($success_message)): ?>
    <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
<?php endif; ?>
<form action="ChangePassword.php" method="post" class="d-flex border flex-column p-5">
  <div class="d-flex col-7 mx-auto p-3">
    <label for="current_password" class="col-2">Mật khẩu hiện tại</label>
    <input type="password" id="current_password" name="current_password" required class="form-control col-4" />
  </div>
  <div class="d-flex col-7 mx-auto p-3">
    <label for="new_password" class="col-2">Mật khẩu mới</label>
    <input type="password" id="new_password" name="new_password" required class="form-control col-4" />
  </div>
  <div class="d-flex col-7 mx-auto p-3">
    <label for="confirm_password" class="col-2">Xác nhận mật khẩu</label>
    <input type="password" id="confirm_password" name="confirm_password" required class="form-control col-4" />
  </div>
  <input class="btn-success col-5 mx-auto p-2 mt-3" type="submit" value="Đổi mật khẩu">
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<?php include 'Footer.php'; ?>
