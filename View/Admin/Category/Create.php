<?php
include_once '../../Header.php';
include_once "../../../Database/Connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maLoai = $_POST["MaLoai"];
    $tenLoai = $_POST["TenLoai"];

    $query = "INSERT INTO loaisanpham (MaLoai, TenLoai) VALUES ('$maLoai', '$tenLoai')";

    if ($conn->query($query)) {
        echo "Thêm loại sản phẩm thành công.";
        // header('Location: Index1.php');
        // exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<div class="container">
    <h1 class="text-center text-info">Thêm loại sản phẩm</h1>
    <form action="Create.php" method="post" class="col-7 form-control p-5">
        <div class="row py-3">
            <label class="col-2">Mã loại sản phẩm</label>
            <input class="col-2 p-1 me-4" placeholder="ID" value="010" readonly id="MaLoai" name="MaLoai"/>
            <label class="col-2">Tên loại sản phẩm</label>
            <input class="col-5 p-1" type="text" placeholder="Tên sản phẩm" id="TenLoai" name="TenLoai" />
        </div>
        <button type="submit" class="btn btn-success px-3 py-2">Thêm</button>
        <a class="btn btn-warning px-3 py-2" href="Index1.php">Trở lại</a>
    </form>
</div>

<?php include_once '../../Footer.php'; ?>