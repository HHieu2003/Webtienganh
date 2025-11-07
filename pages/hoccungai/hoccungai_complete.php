<?php
/**
 * HỌC CÙNG AI - MAIN PAGE (PHIÊN BẢN HIỆN ĐẠI HÓA)
 * Complete English Learning System with AI
 * Version: 3.1
 */

require_once 'config.php'; // Đảm bảo đường dẫn này đúng
include('./config/config.php');

// Check login status
$isLoggedIn = isset($_SESSION['id_hocvien']) && !empty($_SESSION['id_hocvien']);
$userId = $_SESSION['id_hocvien'] ?? 0;
$userName = 'Guest';

if ($isLoggedIn && $conn) {
    try {
        $stmt_hocvien = $conn->prepare("SELECT ten_hocvien FROM hocvien WHERE id_hocvien = ?");
        $stmt_hocvien->bind_param("i", $userId);
        $stmt_hocvien->execute();
        $result_hocvien = $stmt_hocvien->get_result();

        if ($row = $result_hocvien->fetch_assoc()) {
            $userName = $row['ten_hocvien'];
        }
        $stmt_hocvien->close();
    } catch (Exception $e) {
        // Ghi lại lỗi nếu cần, nhưng không làm dừng trang
        error_log("Database error fetching user name: " . $e->getMessage());
        $userName = 'Student'; // Tên mặc định nếu có lỗi
    }
}

// Generate CSRF token
$csrfToken = SecurityHelper::generateCSRFToken();

// Log page access
if ($isLoggedIn) {
    Logger::info('User accessed Hoc Cung AI', [
        'user_id' => $userId,
        'user_name' => $userName
    ]);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title><?php echo defined('APP_NAME') ? APP_NAME : 'Học Cùng AI'; ?> - Học tiếng Anh thông minh</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="pages/hoccungai/hoccungai_complete.css"> 
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrfToken); ?>">
</head>
<body class="ai-learning-page">

<div class="ai-container">

    <header class="ai-header" id="ai-header">
        <button class="header-collapse-btn" id="header-collapse-btn" title="Thu gọn header">
            <i class="fas fa-chevron-up"></i>
        </button>
        <div class="header-content">
            <h1>
                <i class="fas fa-robot header-icon"></i>
                <?php echo defined('APP_NAME') ? APP_NAME : 'Học Cùng AI'; ?>
            </h1>
            <p>Nền tảng luyện tập tiếng Anh toàn diện với sự hỗ trợ của AI</p>
            <?php if ($isLoggedIn): ?>
                <div class="user-welcome">
                    <i class="fas fa-user-circle"></i>
                    <span>Xin chào, <strong><?php echo htmlspecialchars($userName); ?></strong>!</span>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <?php if (!$isLoggedIn): ?>
        <main class="ai-main-content">
            <div class="login-prompt-container">
                <div class="login-prompt-card">
                    <i class="fas fa-lock login-prompt-icon"></i>
                    <h2>Yêu cầu đăng nhập</h2>
                    <p>Để trải nghiệm đầy đủ các tính năng học tập thú vị cùng AI, bạn vui lòng đăng nhập.</p>
                    <a href="pages/login.php" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập ngay
                    </a>
                </div>
            </div>
        </main>
    <?php else: ?>
        <div class="ai-app-layout">

            <!-- Mobile Menu Button (visible only on mobile) -->
            <button class="mobile-menu-btn" id="mobile-menu-btn" style="display: none; padding: 7px; border-radius: 15px; background-color: #31bc3fff; color: #fff; ">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Sidebar Navigation -->
            <aside class="skill-sidebar" id="skill-sidebar">
                <div class="sidebar-header">
                    <h3><i class="fas fa-graduation-cap"></i> Kỹ Năng</h3>
                    <button class="sidebar-toggle" id="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <nav class="skill-tabs-nav">
                    <div class="skill-tabs-wrapper">
                        <button class="skill-tab-btn active" data-skill="listening">
                            <i class="fas fa-headphones"></i><span>Nghe</span>
                        </button>
                        <button class="skill-tab-btn" data-skill="speaking">
                            <i class="fas fa-microphone"></i><span>Nói</span>
                        </button>
                        <button class="skill-tab-btn" data-skill="reading">
                            <i class="fas fa-book-open"></i><span>Đọc</span>
                        </button>
                        <button class="skill-tab-btn" data-skill="writing">
                            <i class="fas fa-pen-fancy"></i><span>Viết</span>
                        </button>
                        <button class="skill-tab-btn" data-skill="vocabulary">
                            <i class="fas fa-spell-check"></i><span>Từ Vựng</span>
                        </button>
                        <button class="skill-tab-btn" data-skill="grammar">
                            <i class="fas fa-book"></i><span>Ngữ Pháp</span>
                        </button>
                        <button class="skill-tab-btn" data-skill="pronunciation">
                            <i class="fas fa-volume-up"></i><span>Phát Âm</span>
                        </button>
                        <button class="skill-tab-btn" data-skill="communication">
                            <i class="fas fa-comments"></i><span>Giao Tiếp</span>
                        </button>
                    </div>
                </nav>
            </aside>

            <!-- Mobile Overlay -->
            <div class="sidebar-overlay" id="sidebar-overlay"></div>

            <!-- Main Content Area -->
            <div class="ai-content-wrapper">
                <div class="ai-scrollable-content">
                    <main class="ai-main-content">
                    <?php
                    // Function to safely include files
                    function safe_include($file_path) {
                        if (file_exists($file_path)) {
                            include $file_path;
                        } else {
                            // Display an error message if the file is missing
                            echo "<div class='error-message' style='padding: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; color: #721c24; margin: 20px;'>";
                            echo "<i class='fas fa-exclamation-triangle'></i> Lỗi: Không tìm thấy file giao diện '<code>" . htmlspecialchars(basename($file_path)) . "</code>'. Vui lòng kiểm tra lại đường dẫn.";
                            echo "</div>";
                            // Log the error for developers
                            error_log("HocCungAI Error: UI file not found at " . $file_path);
                        }
                    }

                    // Include UI files for each skill
                    safe_include(__DIR__ . '/listening_content_ui.php');
                    safe_include(__DIR__ . '/speaking_content_ui.php');
                    safe_include(__DIR__ . '/reading_content_ui.php');
                    safe_include(__DIR__ . '/writing_content_ui.php');
                    safe_include(__DIR__ . '/vocabulary_content_ui.php');
                    safe_include(__DIR__ . '/grammar_content_ui.php');
                    safe_include(__DIR__ . '/pronunciation_content_ui.php');
                    safe_include(__DIR__ . '/communication_content_ui.php');
                    ?>
                </main>
            </div>
            </div> <!-- End ai-content-wrapper -->

        </div> <!-- End ai-app-layout -->
    <?php endif; ?>

</div> <div id="toast-container" class="toast-container"></div>

<script src="pages/hoccungai/hoccungai_complete.js"></script> 
</body>
</html>