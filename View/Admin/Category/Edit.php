<?php include '../../Header.php';
include("../../../Database/Connect.php");
$id=$_GET['id'];
if(isset($id))
{
$strdsloai="select tenloai from loaisanpham where maloai='$id'";
}
$dsloai=$conn->query($strdsloai);
$loai=$dsloai->fetch();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maLoai = $_POST["MaLoai"];
    $tenLoai = $_POST["TenLoai"];

    $query = "UPDATE loaisanpham SET TenLoai = '$tenLoai' WHERE MaLoai = '$maLoai'";

    if ($conn->query($query)) {
       
          // header("Location: Index1.php");
          //   exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }

   // $conn->close();
}
?>

<div class="container">
    <h1 class="text-center text-info">Sửa loại sản phẩm</h1>
    <form action="Edit.php?id=<?php echo $id?>" method="post" class="col-7 form-control p-5">
        <div class="row py-3">
            <label class="col-2">Mã loại sản phẩm</label>
            <input class="col-5 p-1" type="text" placeholder="Mã loại sản phẩm" id="MaLoai" name="MaLoai" value="<?php echo $id?>" readonly/>
        </div>
        <div class="row py-3">
            <label class="col-2">Tên loại sản phẩm</label>
            <input class="col-5 p-1" type="text" placeholder="Tên loại sản phẩm" id="TenLoai" name="TenLoai" value="<?php echo $loai['tenloai'];?>" />
        </div>
        <a class="btn btn-warning px-3 py-2" href="Index1.php">Trở lại</a>
        <button type="submit" class="btn btn-info px-3 py-2">Cập nhật</button>
     
    </form>
</div>
<?php include '../../Footer.php'?>