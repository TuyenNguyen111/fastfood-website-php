
<?php include_once '../../Header.php';
include_once("../../../Database/Connect.php"); 
$id= $_GET['id'];
$query3="select * from loaisanpham";
if(isset($id))
{
    $sanphamm="select * from sanpham where masanpham='$id'";
}
$rows=$conn->query($sanphamm);
$row=$rows->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $masp=$_POST['masp'];
     $tensp=$_POST['ProductName'];
     $giaban=$_POST['Price'];
     $tinhtrang=$_POST['tinhTrang'];
     $loaisp=$_POST['maLoai'];
     $mota=$_POST['mota'];
     $hinhanh=$_POST['urlHinhAnh'];


if ($hinhanh!='noimage.png'&&$hinhanh!='' ) {
    // Xử lý tệp ảnh mới
    $new_image_name = $hinhanh;

    // Lưu ảnh mới vào cơ sở dữ liệu
    
} else {
    // Lưu ảnh cũ vào cơ sở dữ liệu
     $new_image_name='noimage.png';
}
	echo $masp;
	echo $loaisp;
//	$query2 ="select MaLoai from loaisanpham where tenloai='$'";
//	$result2=$conn->query($query2);
//	$row2=$result2->fetch();
//	$maloai=$row2['MaLoai'];
	
    $query = "UPDATE sanpham SET tensanpham='$tensp',mota='$mota',gia='$giaban',tinhtrang='$tinhtrang',maloai='$loaisp',urlhinhanh='$new_image_name' WHERE Masanpham = '$masp'";
	if ($conn->query($query) == TRUE) {
    echo "<script>alert \"Sửa sản phẩm thành công\"</script>";
} 
else {
    echo "Lỗi khi  sản phẩm: " ;
}

	
//    if ($conn->query($query)) {
//       
//          // header("Location: Index1.php");
//          //   exit();
//    } else {
//        echo "Lỗi " ;
//    }

   // $conn->close();
}
// Lấy ảnh cũ từ cơ sở dữ liệu

?>
<div class="container">
    <h1 class="text-center text-info">Sửa thông tin sản phẩm</h1>
    <form action="/LTMNM_DeTai1/View/Admin/Product/Edit.php?id=<?php echo $id?>" method="post" class="col-7 form-control p-5" >
        <div class="row py-3">
        <label class="col-2">ID</label>
        <input class="col-2 p-1 me-4" placeholder="ID" name="masp" value="<?php echo $row['MaSanPham'];?>" readonly />
        <label class="col-2">Tên sản phẩm</label>
        <input class="col-5 p-1" type="text" id="ProductName" name="ProductName" value="<?php echo $row['TenSanPham'];?>"  />
    </div>

    <div class="row  py-3">
        <label class="col-2">Giá bán</label>
        <input class="col-2 p-1 me-2" type="text" id="Price" name="Price" value="<?php echo $row['Gia'];?>"   />



    </div>

    <div class="row py-3">

            <label class="col-2" for="Status">Tình trạng</label>

            <select class="col-6 p-1" id="tinhTrang" name="tinhTrang">
                <option value="Còn hàng" selected>Còn hàng</option>
                <option value="Hết hàng">Hết hàng</option>
            </select>
        </div>

  
    <div class="row py-3">

        <label class="col-2" for="Categories">Loại sản phẩm</label>
       

   	<select class="col-3 p-1" id="maLoai" name="maLoai">
                           <?php
                    foreach($conn->query($query3) as $loai)
                    {
                    
                        if($row["MaLoai"]==$loai['MaLoai'])
                        {
							    ?>
                        <option value="<?php echo $loai['MaLoai'] ?>" selected><?php echo $loai['TenLoai']?></option>
                       <?php }?>
                        <option value="<?php echo $loai['MaLoai'] ?>"><?php echo $loai['TenLoai']?></option>
                        <?php
                    }
                    ?>
		</select>    
      </div>

    <div class="row  py-3">
        <label class="col-2">Mô tả</label>
        <input class="col-6 p-1 me-2" type="text" id="mota" name="mota" value="<?php echo $row['MoTa'];?>" />



    </div>

    <div class="row py-3">
        <label class="col-2">Ảnh</label>
       
            <img id="imgsp" src="../../../Img/<?php echo $row['URLHinhAnh']?>" style="width:100px;height:100px ;border:2px solid grey " />
            <input type="file" name="urlHinhAnh" id="urlHinhAnh" accept="image/*">
        </div>
    
    <button type="submit" class="btn-danger px-3 py-2 mx-3" onsubmit="return confirmDelete();">Cập nhật</button>
    <a href="/LTMNM_DeTai1/View/Admin/Product/Index1.php" class="btn btn-warning px-3 py-2">Trở lại </a>
    
    </form>
</div>

<?php include_once '../../Footer.php';
if($_SERVER['REQUEST_METHOD']==='POST')
{

   echo '<script>window.location.href = "Index1.php";</script>';
}?>
<script type="text/javascript">
   
       function confirmDelete() {
            var result = confirm("Bạn có chắc chắn muốn sửa?");

            return result;
        }
   
</script>
<input type="file" id="file-input">

<!-- <script>
 function validateForm() {
    var fileInput = document.getElementById('urlHinhAnh');
	 var imgsrc=document.getElementById('imgsp').src;
    // Kiểm tra xem input file có được chọn không
    if (fileInput.files.length > 0) {
      // Nếu có, lấy đường dẫn của tập tin được chọn
      var fileUrl = URL.createObjectURL(fileInput.files[0]);
      alert("có chọn");
		alert(imgsrc.text);
      // Thay đổi giá trị của input file trước khi submit
      fileInput.value = fileUrl;
    } else {
		alert("không chọn");
		alert(imgsrc.text);
      // Nếu không, thay đổi giá trị của input file thành "a"
      fileInput.value = "../../../Img/noimage.png";
		
    }

    // Tiếp tục submit form
    return true;
  }
</script> -->