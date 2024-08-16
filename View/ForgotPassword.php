<?php
include 'Header.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'User/vendor/PHPMailer/src/Exception.php';
require 'User/vendor/PHPMailer/src/PHPMailer.php';
require 'User/vendor/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    include("../Database/Connect.php");

    $sql = "SELECT * FROM nguoidung WHERE Email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $new_password = bin2hex(random_bytes(4)); // Generate a random 8-character password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_sql = "UPDATE nguoidung SET MatKhau = :password WHERE Email = :email";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':password', $hashed_password);
        $update_stmt->bindParam(':email', $email);
        if ($update_stmt->execute()) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'duongtugiaucuong@gmail.com'; // Your Gmail email address
                $mail->Password = 'yfuedyjohrinlyhd'; // Your Gmail app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption
                $mail->Port = 587; // TCP port to connect to

                $mail->setFrom('duongtugiaucuong@gmail.com', 'Cake DouF');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = '=?UTF-8?B?' . base64_encode('Mật khẩu mới của bạn') . '?=';
                $mail->Body = 'Mật khẩu mới của bạn là: ' . $new_password;

                $mail->send();
                echo '<script>alert("Mật khẩu mới đã được gửi đến email của bạn."); window.location.href = "SignIn.php";</script>';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Cập nhật mật khẩu thất bại: " . $update_stmt->errorInfo()[2];
        }
    } else {
        echo '<script>alert("Email không tồn tại trong hệ thống.");</script>';
    }

    $conn = null;
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Quên mật khẩu</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<h2 class="text-primary fs-1 text-center mt-5">Quên mật khẩu</h2>
<form action="ForgotPassword.php" method="post" class="d-flex border flex-column p-5">
  <div class="d-flex col-7 mx-auto p-3">
    <label for="email" class="col-2">Email</label>
    <input type="email" id="email" name="email" required class="form-control col-4" />
  </div>
  <input class="btn-success col-5 mx-auto p-2 mt-3" type="submit" value="Gửi mật khẩu mới">
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<?php include 'Footer.php'; ?>
