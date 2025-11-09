<?php
// Lấy giá trị của 'nav' từ URL, nếu không có thì mặc định là rỗng để tải trang 'home'
$nav = $_GET['nav'] ?? '';

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

    case 'view_submission':
        include("modules/view_test_submission.php");
        break;

    case 'thongbao':
        include("modules/thongbao.php");
        break;

case 'sua_bai_viet':
        include("modules/sua_bai_viet.php");
        break;
    case 'viet_bai':
        include("modules/viet_bai.php");
        break;
    case 'bai_viet_cua_toi':
        include("modules/bai_viet_cua_toi.php");
        break;

    default: // Nếu 'nav' không khớp hoặc rỗng, sẽ chạy trang chủ của dashboard
        include("modules/home.php");
        break;
}
