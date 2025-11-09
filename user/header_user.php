<?php
// File: user/header_user.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="dashboard-header">
    <div class="header-left">
        <button class="menu-toggle" id="menu-toggle-btn">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a class="logo" href="../index.php" aria-label="Trang chủ">
            <img src="../images/logo2.jpg" alt="Tiếng Anh Fighter! logo">
        </a>
        <span class="header-title">Trang cá nhân</span>
    </div>
    <div class="header-right">
        <a href="../index.php" class="header-link" title="Quay về trang chủ">
            <i class="fa-solid fa-house"></i>
            <span class="d-none d-md-inline"> Về trang chủ &nbsp; | </span>
        </a>
        <a href="./dashboard.php?nav=thongbao" class="header-link" title="Thông báo">
            <i class="fa-solid fa-bell"></i>
            <?php 
                // Biến $unread_count được lấy từ dashboard.php
                if (isset($unread_count) && $unread_count > 0) {
                    echo "<span class='notification-badge'>$unread_count</span>";
                }
            ?>
        </a>
        <div class="user-menu">
            <?php
            // Lấy ảnh đại diện của học viên cho header
            $header_avatar = '../images/logo.png'; // Ảnh mặc định
            if (isset($_SESSION['id_hocvien'])) {
                $sql_header_avatar = "SELECT hinh_anh FROM hocvien WHERE id_hocvien = ?";
                $stmt_header_avatar = $conn->prepare($sql_header_avatar);
                $stmt_header_avatar->bind_param("i", $_SESSION['id_hocvien']);
                $stmt_header_avatar->execute();
                $result_header_avatar = $stmt_header_avatar->get_result();
                if ($row_header_avatar = $result_header_avatar->fetch_assoc()) {
                    if (!empty($row_header_avatar['hinh_anh'])) {
                        $avatar_path = "../" . $row_header_avatar['hinh_anh'];
                        if (file_exists($avatar_path)) {
                            $header_avatar = $avatar_path;
                        }
                    }
                }
                $stmt_header_avatar->close();
            }
            ?>
            <img src="<?php echo htmlspecialchars($header_avatar); ?>" alt="Avatar" class="user-avatar" onerror="this.src='../images/logo.png';">
            <span class="user-name d-none d-lg-inline"><?php echo htmlspecialchars($_SESSION['user']); ?></span>
        </div>
    </div>
</div>