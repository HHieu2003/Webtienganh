<?php
// Lấy giá trị của 'nav' từ URL, nếu không có thì mặc định là rỗng để tải trang 'home'
$nav = $_GET['nav'] ?? '';

// Sử dụng switch-case để code dễ đọc và bảo trì hơn
switch ($nav) {
    case 'khoahoc':
        include("modules/khoahoc.php");
        break;

    case 'lichhoc':
        include("modules/lichhoc.php");
        break;

    case 'thongtin':
        include("modules/thongtintaikhoan.php");
        break;

         case 'bangdiem':
        include("modules/bangdiem.php");
        break;
    case 'baomat':
        include("modules/baomattk.php");
        break;

    case 'tiendo':
        include("modules/tiendo.php");
        break;

    case 'lichhoctuan':
        include("modules/lichhoctuan.php");
        break;

    case 'hoclieu':
        include("modules/hoclieu.php");
        break;
    case 'lichsuthanhtoan':
        include("modules/lichsuthanhtoan.php");
        break;
 case 'diemdanh':
        include("modules/diemdanh.php");
        break;
    case 'ketquakiemtra':
        include("modules/ketquakiemtra.php");
        break;
case 'thongbao':
        include("modules/thongbao.php");
        break;
    default: // Nếu 'nav' không khớp hoặc rỗng, sẽ chạy trang chủ của dashboard
        include("modules/home.php");
        break;
}
