
<?php {
    if (isset($_GET['nav'])) {
        $temp = $_GET['nav'];
    } else {
        $temp = '';
    }
}

if ($temp == 'khoahoc') {
    include("modules/khoahoc.php");
} 

else if ($temp == 'lichhoc') {
    include("modules/lichhoc.php");
} 
else if ($temp == 'thongtin') {
    include("modules/thongtintaikhoan.php");
} 
else if ($temp == 'thongtin') {
    include("modules/thongtintaikhoan.php");
} 
else if ($temp == 'baomat') {
    include("modules/baomattk.php");
} 
else if ($temp == 'tiendo') {
    include("modules/tiendo.php");
} 
else if ($temp == 'lichsuthanhtoan') {
    include("modules/lichsuthanhtoan.php");
} 
else if ($temp == 'ketquakiemtra') {
    include("modules/ketquakiemtra.php");
} 
else {
    include("modules/home.php");
}
?>
