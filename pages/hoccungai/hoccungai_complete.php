<?php
/**
 * HỌC CÙNG AI - MAIN PAGE
 * Complete English Learning System with AI
 * Version: 3.0
 */

require_once 'config.php';

// Check login status
$isLoggedIn = isset($_SESSION['id_hocvien']) && !empty($_SESSION['id_hocvien']);
$userId = $_SESSION['id_hocvien'] ?? 0;
$userName = 'Guest';

if ($isLoggedIn && $conn) {
    $stmt_hocvien = $conn->prepare("SELECT ten_hocvien FROM hocvien WHERE id_hocvien = ?");
    $stmt_hocvien->bind_param("i", $userId);
    $stmt_hocvien->execute();
    $result_hocvien = $stmt_hocvien->get_result();
    
    if ($row = $result_hocvien->fetch_assoc()) {
        $userName = $row['ten_hocvien'];
    }
    $stmt_hocvien->close();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Học tiếng Anh thông minh với AI</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="pages/hoccungai/hoccungai_complete.css">
    
    <meta name="csrf-token" content="<?php echo $csrfToken; ?>">
</head>
<body>

<div class="learn-ai-container">
    <div class="container">
        
        <!-- ============================================ -->
        <!-- HEADER -->
        <!-- ============================================ -->
        <div class="ai-header">
            <h1>
                <i class="fas fa-robot"></i>
                <?php echo APP_NAME; ?>
            </h1>
            <p>Học tiếng Anh thông minh với công nghệ AI - Phát triển toàn diện 4 kỹ năng</p>
            
            <?php if ($isLoggedIn): ?>
                <div class="user-welcome">
                    <i class="fas fa-user-circle"></i>
                    Xin chào, <strong><?php echo htmlspecialchars($userName); ?></strong>!
                </div>
            <?php endif; ?>
        </div>

        <!-- ============================================ -->
        <!-- MAIN CONTENT -->
        <!-- ============================================ -->
        <?php if (!$isLoggedIn): ?>
            <!-- Login Prompt -->
            <div class="login-prompt">
                <i class="fas fa-lock"></i>
                <h2>Đăng nhập để bắt đầu</h2>
                <p>Bạn cần đăng nhập để sử dụng đầy đủ các tính năng học tập với AI</p>
                <a href="index.php?page=login" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập ngay
                </a>
            </div>
        <?php else: ?>
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            
            <!-- ============================================ -->
            <!-- SIDEBAR - Navigation -->
            <!-- ============================================ -->
            <aside class="sidebar">
                
                <!-- Core Skills -->
                <div class="skill-category">
                    <h3><i class="fas fa-graduation-cap"></i> Kỹ Năng Cốt Lõi</h3>
                    
                    <div class="skill-item active" data-skill="listening">
                        <i class="fas fa-headphones"></i>
                        <div class="skill-info">
                            <div class="skill-name">Luyện Nghe</div>
                            <div class="skill-desc">Listening</div>
                        </div>
                    </div>

                    <div class="skill-item" data-skill="speaking">
                        <i class="fas fa-microphone"></i>
                        <div class="skill-info">
                            <div class="skill-name">Luyện Nói</div>
                            <div class="skill-desc">Speaking</div>
                        </div>
                    </div>

                    <div class="skill-item" data-skill="reading">
                        <i class="fas fa-book-open"></i>
                        <div class="skill-info">
                            <div class="skill-name">Luyện Đọc</div>
                            <div class="skill-desc">Reading</div>
                        </div>
                    </div>

                    <div class="skill-item" data-skill="writing">
                        <i class="fas fa-pen-fancy"></i>
                        <div class="skill-info">
                            <div class="skill-name">Luyện Viết</div>
                            <div class="skill-desc">Writing</div>
                        </div>
                    </div>
                </div>

                <!-- Additional Skills -->
                <div class="skill-category">
                    <h3><i class="fas fa-star"></i> Kỹ Năng Bổ Trợ</h3>
                    
                    <div class="skill-item" data-skill="vocabulary">
                        <i class="fas fa-spell-check"></i>
                        <div class="skill-info">
                            <div class="skill-name">Từ Vựng</div>
                            <div class="skill-desc">Vocabulary</div>
                        </div>
                    </div>

                    <div class="skill-item" data-skill="grammar">
                        <i class="fas fa-book"></i>
                        <div class="skill-info">
                            <div class="skill-name">Ngữ Pháp</div>
                            <div class="skill-desc">Grammar</div>
                        </div>
                    </div>

                    <div class="skill-item" data-skill="pronunciation">
                        <i class="fas fa-volume-up"></i>
                        <div class="skill-info">
                            <div class="skill-name">Phát Âm</div>
                            <div class="skill-desc">Pronunciation</div>
                        </div>
                    </div>

                    <div class="skill-item" data-skill="communication">
                        <i class="fas fa-comments"></i>
                        <div class="skill-info">
                            <div class="skill-name">Giao Tiếp</div>
                            <div class="skill-desc">Communication</div>
                        </div>
                    </div>
                </div>

                <!-- Progress Summary -->
                <div class="progress-summary">
                    <h4><i class="fas fa-chart-line"></i> Tiến Độ Học Tập</h4>
                    <div class="stat-item">
                        <span>Bài hoàn thành:</span>
                        <strong id="completed-count">0</strong>
                    </div>
                    <div class="stat-item">
                        <span>Điểm trung bình:</span>
                        <strong id="average-score">0</strong>
                    </div>
                    <div class="stat-item">
                        <span>Ngày liên tiếp:</span>
                        <strong id="streak-days">0</strong>
                    </div>
                </div>

            </aside>

            <!-- ============================================ -->
            <!-- MAIN CONTENT AREA -->
            <!-- ============================================ -->
            <main class="main-content">

                <!-- LISTENING CONTENT -->
                <?php include 'pages/hoccungai/listening_content_ui.php'; ?>

                <!-- SPEAKING CONTENT -->
                <?php include 'pages/hoccungai/speaking_content_ui.php'; ?>

                <!-- READING CONTENT -->
                <?php include 'pages/hoccungai/reading_content_ui.php'; ?>

                <!-- WRITING CONTENT -->
                <?php include 'pages/hoccungai/writing_content_ui.php'; ?>

                <!-- VOCABULARY CONTENT -->
                <?php include 'pages/hoccungai/vocabulary_content_ui.php'; ?>

                <!-- GRAMMAR CONTENT -->
                <?php include 'pages/hoccungai/grammar_content_ui.php'; ?>

                <!-- PRONUNCIATION CONTENT -->
                <?php include 'pages/hoccungai/pronunciation_content_ui.php'; ?>

                <!-- COMMUNICATION CONTENT -->
                <?php include 'pages/hoccungai/communication_content_ui.php'; ?>

            </main>

        </div>
        
        <?php endif; ?>

    </div>
</div>

<!-- JavaScript -->
<script src="pages/hoccungai/hoccungai_complete.js"></script>

</body>
</html>
