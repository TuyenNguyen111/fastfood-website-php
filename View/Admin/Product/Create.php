<?php include '../../Header.php';
include("../../../Database/Connect.php"); 
$result ="select * from loaisanpham" ; 
$LastRow="select masanpham from sanpham order by masanpham desc limit 1;";
    $result1=$conn->query($LastRow);
    $row=$result1->fetch();
    $ma=$row['masanpham'];?>

<div class="container">
    <h1 class="text-center text-info">Thêm sản phẩm</h1>
    <form action="Create.php" method="post" class="col-7 form-control p-5" enctype="multipart/form-data"">
        <div class="row py-3">
            <label class="col-2">ID</label>
            <input class="col-2 p-1 me-4" placeholder="ID" value="<?php echo generateProductCode($ma) ?>" id="masp" name="masp" readonly />
            <label class="col-2">Tên sản phẩm</label>
            <input class="col-5 p-1" type="text" placeholder="Tên sản phẩm" id="tenSanPham" name="tenSanPham" />
        </div>

        <div class="row  py-3">
            <label class="col-2">Giá bán</label>
            <input class="col-2 p-1 me-2" type="text" placeholder="Giá bán" id="gia" name="gia" />
        </div>
        <div class="row  py-3">
            <label class="col-2">Mô tả</label>
            <input class="col-2 p-1 me-2" type="text" placeholder="Mô tả" id="mota" name="mota" />
        </div>
        <div class="row py-3">

            <label class="col-2" for="Status">Tình trạng</label>

            <select class="col-6 p-1" id="tinhTrang" name="tinhTrang">
                <option value="Còn hàng">Còn hàng</option>
                <option value="Hết hàng">Hết hàng</option>
            </select>
        </div>
        <div class="row py-3">

            <label class="col-2" for="Brands">Loại sản phẩm</label>

            <select class="col-6 p-1" id="maLoai" name="maLoai">
               
                    <?php
                    foreach($conn->query($result) as $loai)
                    {
                        ?>
                        <option value="<?php echo $loai['MaLoai'] ?>"><?php echo $loai['TenLoai']?></option>
                        <?php
                    }
                    ?>
                

            </select>
        </div>




        

        <div class="row py-3">
            <label class="col-2">Ảnh</label>
             <input type="file" name="urlHinhAnh" id="urlHinhAnh" accept="image/*">
        </div>
        <button type="submit" class="btn-success px-3 py-2" >Thêm</button>
         <a href="Index1.php" class="btn btn-warning px-3 py-2">Trở lại </a>
    </form>
</div>
<?php 
 

   
    function generateProductCode($lastCode) {
    // Trích xuất phần số từ mã sản phẩm cuối cùng
    $lastNumber = intval(substr($lastCode, 2));

    // Tăng giá trị số lên 1
    $nextNumber = $lastNumber + 1;
    
    // Tạo mã sản phẩm mới
    $nextCode = 'SP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    
    return $nextCode;
    }
   
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $maSP=$_POST["masp"];;
    $tenSanPham = $_POST["tenSanPham"];
    $moTa = $_POST["mota"];
    $gia = $_POST["gia"];
    $tinhTrang = $_POST["tinhTrang"];
    $urlHinhAnh = $_FILES['urlHinhAnh']['name'];
    $maLoai = $_POST["maLoai"];
    $maSP=$_POST["masp"];
    // Thêm sản phẩm vào cơ sở dữ liệu
    $sql = "INSERT INTO sanpham (MaSanPham,TenSanPham, MoTa, Gia, TinhTrang, URLHinhAnh, MaLoai) VALUES ('$maSP','$tenSanPham', '$moTa', '$gia', '$tinhTrang', '$urlHinhAnh', '$maLoai')";

    if ($conn->query($sql) == TRUE) {
        echo "Thêm sản phẩm thành công.";
    } else {
        echo "Lỗi khi thêm sản phẩm: " ;
    }
    
    // Đường dẫn lưu trữ tệp tải lên
    $targetDirectory = dirname(dirname(dirname(__DIR__))) . "\Img\ ";
   

    // Kiểm tra xem có tệp tin được tải lên hay không
    if (isset($_FILES["urlHinhAnh"]) && $_FILES["urlHinhAnh"]["error"] == UPLOAD_ERR_OK) {
        $sourceFile = $_FILES["urlHinhAnh"]["tmp_name"];
        $fileName = $_FILES["urlHinhAnh"]["name"];
        $targetFile = $targetDirectory . $fileName;

        // Di chuyển tệp tin vào thư mục đích
        if (move_uploaded_file($sourceFile, $targetFile)) {
            echo "Đã di chuyển tệp ảnh thành công.";
        } else {
            echo "Đã xảy ra lỗi khi di chuyển tệp ảnh.";
        }
    } else {
        echo "Không tìm thấy tệp tin ảnh được tải lên.";
    }
}
    exit();
?>
<?php include '../../Footer.php'?>

