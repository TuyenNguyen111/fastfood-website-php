<?php 
include_once '../../Header.php';
$madon="";
$stt=1;
$sum=0;
?>
<style>
	    .Pagination {
        margin-top: 30px;
        text-align: center;
		margin:auto;
    }

    .Pagination a {
        display: inline-block;
        padding: 8px 16px;
        text-decoration: none;
        background-color: #007bff;
        color: #ffffff;
        border-radius: 20px;
        margin: 5px;
    }

    .Pagination a:hover {
        background-color: #0056b3;
    }

    .Pagination .current {
        background-color: #0056b3;
    }


</style>
<!-- <button style="float:right" type="submit" class="btn btn-success"><a href="Create.php" class="text-white">Thêm sản phẩm</a></button> -->

<form class="d-flex justify-content-center my-3 me-3" action="Index1.php"  method="post">
                    <input class="py-3" width="300px" type="text" id="search" name="search" value="<?php echo $madon?>"placeholder="Mã đơn hàng">
                    <button class="btn-success d-flex align-items-center justify-content-between btn text-white px-3" type="submit">
                        <i class='bx bx-search fs-6 mx-2'></i>
                    </button>
                </form>
    <?php
    // Gọi kết nối
    include("../../../DataBase/Connect.php");
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $madon=$_POST['search'];
        
    // Kiểm tra kết nối
    if ($conn) {

        $querySeDH="select * from donhang where MaDon='$madon'";
        $resultSeDH=$conn->query($querySeDH);
        if($resultSeDH->rowCount()>0)
        {
            $rowSeDH=$resultSeDH->fetch();
        }
        else
        {
            echo "Không tìm thấy kết quả";
        }
        //


        $querySeCTDH="select * from chitietdonhang where MaDon='$madon'";
        $resultSeCTDH=$conn->query($querySeCTDH);
       
        
       


        // Số lượng bản ghi trên mỗi trang
        $display = 5;
        // Trang hiện tại
        $curr_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        // Vị trí bắt đầu lấy bản ghi
        $position = ($curr_page - 1) * $display;

        // Tạo điều kiện tìm kiếm
        $search_condition = '';
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_term = $_GET['search'];
            $search_condition = " WHERE TenLoai LIKE '%$search_term%'";
        }

        // Câu truy vấn lấy dữ liệu với phân trang và điều kiện tìm kiếm
        $sql = "SELECT * FROM loaisanpham $search_condition ORDER BY MaLoai ASC LIMIT $position, $display";
        $SP = $conn->query($sql);

        // Hiển thị sản phẩm
        if ($SP) {
            // Kiểm tra số lượng sản phẩm
            if ($SP->rowCount() > 0) {
                ?>
                <div>
                    <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Mã khách</th>
                            <th>Tên khách</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Phương thức thanh toán</th>
                            <th>Thời gian tạo đơn</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td ><?php echo $rowSeDH["MaDon"]?></td>
                            <td ><?php echo $rowSeDH["MaKH"]?></td>
                            <td ><?php echo $rowSeDH["TenKhachHang"]?></td>
                            <td ><?php echo $rowSeDH["SoDienThoai"]?></td>
                            <td ><?php echo $rowSeDH["DiaChi"]?></td>
                            <td ><?php echo $rowSeDH["PhuongThucThanhToan"]?></td>
                            <td ><?php echo $rowSeDH["ThoiGianTaoDon"]?></td>
                        </tr>
                        
                    </tbody>
                    </table>
                </div>
                <h2 class="fw-bold text-center text-success">Chi tiết đơn hàng</h2>
                <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>STT</th>
                        <th>Mã chi tiết đơn đặt</th>
                        <th>Mã đơn</th>
                        <th>Món </th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(!$resultSeCTDH->rowCount()>0)
                            {
                                echo "Không tìm thấy kết quả";
                              
                            }
                            else
                            {
                                  
                            ?>
                <div class="d-flex flex-wrap justify-content-center">
                    <?php foreach ($resultSeCTDH as $rowSeCTDH): 
                        $masp=$rowSeCTDH['MaSanPham'] ;
                          $querySeSP="select * from sanpham where MaSanPham='$masp'";
                            $resultSeSP=$conn->query($querySeSP);
                            $rowSeSP=$resultSeSP->fetch();
                            ?>

                    	<tr>     
                                <td><?php echo $stt?></td>              
                    			<td><?php echo $rowSeCTDH['MaChiTietDonHang'] ?></td>
                    			<td><?php echo $rowSeCTDH['MaDon'] ?></td>

                                <td><?php echo $rowSeSP['TenSanPham']?></td>
                                <td><?php echo $rowSeCTDH['SoLuong'] ?></td>
                                <td><?php echo $rowSeCTDH['Gia'] ;
                                $sum+=$rowSeCTDH['Gia'];?></td> 
                                $sum+=$rowSeCTDH['Gia'];?></td> 

                      			<td style="width:5%"><a class="btn btn-success text-white"  href="Edit.php?id=<?php echo $lsp['MaLoai'] ?>">Sửa</a></td>
            					<td style="width:5%"><a class="btn btn-danger text-white" href="Delete.php?id=<?php echo $lsp['MaLoai'] ?>">Xóa</a></td>
                			</tr>

                    <?php $stt++; endforeach; ?>
                    <tr>
                            <td colspan="5" class="fw-bold text-center">Tổng tiền </td>
                            <td><?php echo $sum?></td>
                        </tr>
                  <?php  }?>
                </div>
                </tbody>
                </table>
                <?php
                // Tính toán số trang và hiển thị phân trang nếu có dữ liệu
                $sql_count = "SELECT COUNT(*) FROM loaisanpham $search_condition";
                $SO = $conn->query($sql_count);
                if ($SO) {
                    // Đếm tổng số dòng dữ liệu
                    $total_rows = $SO->fetchColumn();
                    // Tính toán số trang
                    $total_pages = ceil($total_rows / $display);
                    // Hiển thị phân trang
                    echo "<div class='Pagination'>";
                    if ($curr_page > 1) {
                        echo "<a href='?page=" . ($curr_page - 1) . "'>&lt; Trang trước</a>";
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $curr_page) {
                            echo "<a class='current'>$i</a>";

                        } else {
                            echo "<a href='?page=$i'>$i</a>";
                        }
                    }
                    if ($curr_page < $total_pages) {
                        echo "<a href='?page=" . ($curr_page + 1) . "'>Trang sau &gt;</a>";
                    }
                    echo "</div>";
                } else {
                    echo "Không có dữ liệu để hiển thị.";
                }
                ?>
                <?php
            } else {
                // Không có sản phẩm nào trùng với từ khóa tìm kiếm
                echo "<p class='text-center'>Không có sản phẩm bạn cần tìm.</p>";
            }
        } else {
            // Có lỗi xảy ra khi thực hiện truy vấn SQL
            echo "Không có sản phẩm nào.";
        }
    } else {
        // Kết nối CSDL không thành công
        echo "Kết nối CSDL không thành công.";
    }

}

 ?>
</center>
<?php include '../../Footer.php'; ?>