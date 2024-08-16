<?php include 'Header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

<h2 class="text-danger fs-1 text-center mt-5">Đăng kí</h2>
<form method="post" action="" class="d-flex border flex-column p-5" id="registrationForm">
    <div class="d-flex col-7 mx-auto p-3">
        <label for="username" class="col-2">Tên đăng nhập</label>
        <input type="text" id="username" name="username" class="form-control col-4" required/>
    </div>
    <div class="d-flex col-7 mx-auto p-3">
        <label for="password" class="col-2">Mật khẩu</label>
        <input type="password" id="password" name="password" class="form-control col-4" required/>
    </div>
    <div class="d-flex col-7 mx-auto p-3">
        <label for="confirm_password" class="col-2">Xác nhận mật khẩu:</label>
        <input type="password" class="form-control col-4" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="d-flex col-7 mx-auto p-3">
        <label for="email" class="col-2">Email</label>
        <input type="email" id="email" name="email" class="form-control col-4" required/>
    </div>
    <div class="d-flex col-7 mx-auto p-3">
        <label for="name" class="col-2">Họ và tên </label>
        <input type="text" id="name" name="name" class="form-control col-4" required/>
    </div>
    <div class="d-flex col-7 mx-auto p-3">
        <label for="address" class="col-2">Địa chỉ</label>
        <input type="text" id="address" name="address" class="form-control col-4" required/>
    </div>
    <div class="d-flex col-7 mx-auto p-3">
        <label for="phonenumber" class="col-2">Số điện thoại</label>
        <input type="text" id="phonenumber" name="phonenumber" class="form-control col-4" required/>
    </div>
  
    <div class="mx-auto">Bạn đã có tài khoản ? <a href="/LTMNM_DeTai1/View/SignIn.php">Đăng nhập</a></div>
    <button class="btn-success col-5 mx-auto p-2 mt-3" type="button" onclick="validateForm()">Đăng ký</button>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
function validateForm() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var email = document.getElementById("email").value;
    var name = document.getElementById("name").value;
    var address = document.getElementById("address").value;
    var phonenumber = document.getElementById("phonenumber").value;

    // Kiểm tra các trường không được để trống
    if (username == "" || password == "" || confirm_password == "" || email == "" || name == "" || address == "" || phonenumber == "") {
        alert("Vui lòng điền đầy đủ thông tin.");
        return false;
    }

    // Kiểm tra mật khẩu và mật khẩu xác nhận phải giống nhau
    if (password != confirm_password) {
        alert("Mật khẩu và mật khẩu xác nhận không khớp.");
        return false;
    }

    // Kiểm tra định dạng email
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.match(emailPattern)) {
        alert("Địa chỉ email không hợp lệ.");
        return false;
    }

    // Kiểm tra định dạng số điện thoại (có thể cải tiến thêm theo định dạng điện thoại cụ thể)
    var phonePattern = /^\d{10,11}$/;
    if (!phonenumber.match(phonePattern)) {
        alert("Số điện thoại không hợp lệ.");
        return false;
    }

    // Nếu các điều kiện đều đúng, submit form
    document.getElementById("registrationForm").submit();
}
</script>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'User/vendor/PHPMailer/src/Exception.php';
require 'User/vendor/PHPMailer/src/PHPMailer.php';
require 'User/vendor/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phonenumber = $_POST['phonenumber'];

    // Kiểm tra xem dữ liệu có hợp lệ không
    if (!empty($username) && !empty($password) && !empty($email)) {
        // Kết nối tới cơ sở dữ liệu
        include("../Database/Connect.php");

        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Thực hiện truy vấn SQL để chèn thông tin người dùng vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO nguoidung (TenDangNhap, MatKhau, Email, HoTen, DiaChi, SoDienThoai, role) VALUES (:username, :password, :email, :name, :address, :phonenumber, 'user')");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phonenumber', $phonenumber);

        if ($stmt->execute()) {
            // Gửi email thông báo
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'duongtugiaucuong@gmail.com';
                $mail->Password = 'yfuedyjohrinlyhd';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                //Recipients
                $mail->setFrom('duongtugiaucuong@gmail.com', 'Your Name');
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);
                $mail->Subject = '=?UTF-8?B?' . base64_encode('Đăng ký thành công') . '?=';
                $mail->Body = 'Chúc mừng! Bạn đã đăng ký thành công với tên đăng nhập: ' . $username . ' và email: ' . $email;

                if ($mail->send()) {
                    echo '<script>alert("Đã đăng ký tài khoản thành công, hãy kiểm tra email.");</script>';
                } else {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Đăng ký thất bại: " . $stmt->errorInfo()[2];
        }

        // Đóng kết nối cơ sở dữ liệu
        $conn = null;
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }
}
?>

</body>
</html>
<?php include 'Footer.php'; ?>
