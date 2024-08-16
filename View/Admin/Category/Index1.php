<?php 
include_once '../../Header.php';
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
<button style="float:right" type="submit" class="btn btn-success"><a href="Create.php" class="text-white">Thêm sản phẩm</a></button>
<form class="d-flex me-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                    <input class="" type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"placeholder="Tìm kiếm sản phẩm">
                    <button class="btn-success d-flex align-items-center justify-content-between btn text-white px-3" type="submit">
                        <i class='bx bx-search fs-6'></i>
                    </button>
                </form>
    <?php
    // Gọi kết nối
    include("../../../DataBase/Connect.php");

    // Kiểm tra kết nối
    if ($conn) {
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
                <h2 class="fw-bold text-center text-success">Danh sách loại sản phẩm</h2>
                <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Mã loại</th>
                        <th>Tên sản phẩm</th>
                    </tr>
                </thead>
                <center>
                <div class="d-flex flex-wrap justify-content-center">
                    <?php foreach ($SP as $lsp): ?>
                    	<tr>                   
                    			<td><?php echo $lsp['MaLoai'] ?></td>
                    			<td><a href="" style="text-decoration:none"><?php echo $lsp['TenLoai'] ?></a></td>                    
                      			<td style="width:5%"><a class="btn btn-success text-white"  href="Edit.php?id=<?php echo $lsp['MaLoai'] ?>">Sửa</a></td>
            					<td style="width:5%"><a class="btn btn-danger text-white" href="Delete.php?id=<?php echo $lsp['MaLoai'] ?>">Xóa</a></td>
                			</tr>
                    <?php endforeach; ?>
                </div>
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
    ?>
</center>
<?php include '../../Footer.php'; ?>