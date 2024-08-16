
<?php 
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
    include("../../../DataBase/Connect.php");
    function generateProductCode($lastCode) {
    // Trích xuất phần số từ mã sản phẩm cuối cùng
    $lastNumber = intval(substr($lastCode, 2));

    // Tăng giá trị số lên 1
    $nextNumber = $lastNumber + 1;
    
    // Tạo mã sản phẩm mới
    $nextCode = 'CM' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    
    return $nextCode;
    }
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $querySelect="select MaPhanHoi from phanhoi order by MaPhanHoi desc limit 1";
    $resultSe=$conn->query($querySelect);
    $rowSe=$resultSe->fetch();
    $maphSe=$rowSe['MaPhanHoi'];

    $maph=generateProductCode($maphSe);
    $mand=$_SESSION['user_id'];
    $masp=$_GET['masp'];
    $noidung=$_POST['review-input'];
    $ngaydang=date('Y-m-d');

    echo $maph;
    echo $mand;
    echo $masp;
    echo $noidung;
    echo $ngaydang;
    $queryIn="insert into phanhoi values ('$maph','$mand','$masp','$noidung','$ngaydang')";
    $resultIn=$conn->query($queryIn);

    header('Location: /LTMNM_DeTai1/View/User/Product/BuyNow.php?id='.$masp);
}

?> 