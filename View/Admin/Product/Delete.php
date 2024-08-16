<?php include '../../Header.php' ;
include("../../../Database/Connect.php"); 

$id= $_GET['id'];
if(isset($id))
{
    $sanphamm="select * from sanpham where masanpham='$id'";
}
$rows=$conn->query($sanphamm);
$row=$rows->fetch(); 
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$sql = "DELETE FROM sanpham WHERE MaSanPham = '$id'";

if ($conn->query($sql) == TRUE) {
    
} 
else {
    echo "Lỗi khi xóa sản phẩm: " ;
}
}
// Đóng kết nối cơ sở dữ liệu

?>
<form action="Delete.php?id=<?php echo $row['MaSanPham'];?>" method="post" onsubmit="return confirmDelete();">
    <h2 style="color:Red ; text-align:center">Xóa sản phẩm</h2>
    <div class="row py-3">
        <label class="col-2">ID</label>
        <input class="col-2 p-1 me-4" placeholder="ID" value="<?php echo $row['MaSanPham'];?>" readonly />
        <label class="col-2">Tên sản phẩm</label>
        <input class="col-5 p-1" type="text" id="ProductName" name="ProductName" value="<?php echo $row['TenSanPham'];?>" readonly />
    </div>

    <div class="row  py-3">
        <label class="col-2">Giá bán</label>
        <input class="col-2 p-1 me-2" type="text" id="Price" value="<?php echo $row['Gia'];?>"  readonly />



    </div>

    <div class="row py-3">

        <label class="col-2" for="Status">Tình trạng</label>

        <input class="col-6 p-1" id="Status" name="Status" value="<?php echo $row['TinhTrang'];?>" readonly>


    </div>

   <!--  <div class="row py-3">

        <label class="col-2" for="Brands">Thương hiệu</label>
        <input class="col-6 p-1" id="BrandID" name="BrandID" value="@Model.Brand.BrandName" readonly>
    </div> -->
    <div class="row py-3">

        <label class="col-2" for="Categories">Loại sản phẩm</label>
        <input class="col-6 p-1" id="CategoryID" name="CategoryID" value="<?php $maloai= $row['MaLoai'];
                      $loai = "select tenloai from loaisanpham where maloai=$maloai ";
                        $result =$conn->query($loai);
                        $kq= $result->fetch();
                        echo $kq['tenloai'] ?>" readonly>
    </div>

    <div class="row  py-3">
        <label class="col-2">Mô tả</label>
        <input class="col-2 p-1 me-2" type="text" id="Quantity" name="Quantity" value="<?php echo $row['MoTa'];?>" readonly />



    </div>

    <div class="row py-3">
        <label class="col-2">Ảnh</label>
       
            <img src="../../../Img/<?php echo $row['URLHinhAnh']?>" style="width:100px;height:100px ;border:2px solid grey " />
        </div>
    
    <button type="submit" class="btn-danger px-3 py-2 mx-3" onclick="XacNhan()">Xóa</button>
    <a href="Index1.php" class="btn btn-warning px-3 py-2">Trở lại </a>
    
</form>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
   
       function confirmDelete() {
            var result = confirm("Bạn có chắc chắn muốn xóa?");

            return result;
        }
   
</script>
<?php /*$maSanPham = $_GET["MaSanPham"];*/

include '../../Footer.php' ;
if($_SERVER['REQUEST_METHOD']==='POST')
{

   echo '<script>window.location.href = "Index1.php";</script>';
}
?>
