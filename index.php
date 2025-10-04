<?php
// 1. Luôn đặt session_start() ở dòng đầu tiên của file
session_start();
include('./config/config.php');


// ================================================================
// === BẮT ĐẦU: CODE NÂNG CẤP ĐỂ ĐẾM LƯỢT TRUY CẬP DUY NHẤT ===
// ================================================================
// Chỉ thực hiện đếm nếu session 'has_counted' chưa được thiết lập
if (!isset($_SESSION['has_counted'])) {
    // Lấy ngày hiện tại
    $current_date = date('Y-m-d');

    // Câu lệnh SQL để tăng số lượt truy cập của ngày hôm nay,
    // hoặc tạo một bản ghi mới nếu hôm nay chưa có ai truy cập.
    $sql_update_views = "
        INSERT INTO luot_truy_cap (ngay_truy_cap, so_luot) 
        VALUES (?, 1) 
        ON DUPLICATE KEY UPDATE so_luot = so_luot + 1
    ";

    // Sử dụng prepared statement để an toàn
    $stmt_views = $conn->prepare($sql_update_views);
    if ($stmt_views) {
        $stmt_views->bind_param("s", $current_date);
        $stmt_views->execute();
        $stmt_views->close();
    }
    
    // Đánh dấu rằng phiên này đã được đếm
    $_SESSION['has_counted'] = true;
}
// ================================================================
// === KẾT THÚC: CODE NÂNG CẤP ===
// ================================================================

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiếng Anh Fighter!</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./pages/main.css">
</head>
<style>
    
body {
    margin: 0;
    padding: 0;
    font-family: 'Times New Roman', Times, serif !important;



}
</style>

<body>

    <div class="wrapper">
        <header>
            <?php include('./pages/header.php'); ?>
        </header>
        
        <section>
            <?php include('./pages/main.php'); ?>
        </section>
        
        <footer>
            <?php include('./pages/footer.php'); ?>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      // Khởi tạo AOS
      AOS.init({
          duration: 1000,
          once: true,
      });
    </script>

</body>
</html>