<?php include_once '../../Header.php';
include_once("../../../Database/Connect.php"); 
$id= $_GET['id'];
if(isset($id))
{
    $sanphamm="select * from sanpham where masanpham='$id'";
}
$rows=$conn->query($sanphamm);
$row=$rows->fetch();

?>

<form class="ms-5 ">
    <h2 style="color:green">Thông tin sản phẩm</h2>
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
    
    <a href="Index1.php" class="btn btn-warning px-3 py-2">Trở lại </a>
</form>
<?php include_once '../../Footer.php'?>
