<?php
// File: pages/main/blog_single.php

// --- Lấy dữ liệu bài viết ---
$id_baiviet = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$is_preview = isset($_GET['preview']) && (isset($_SESSION['is_admin']) && $_SESSION['is_admin']);

if ($id_baiviet === 0) {
    echo "<div class='container text-center my-5'><div class='alert alert-danger'>Bài viết không tồn tại.</div></div>";
    return;
}

if (!$is_preview) {
    // Tăng lượt xem
    $conn->query("UPDATE bai_viet SET luot_xem = luot_xem + 1 WHERE id_baiviet = $id_baiviet");
}

$sql_post = "SELECT bv.*, hv.ten_hocvien FROM bai_viet bv LEFT JOIN hocvien hv ON bv.id_tac_gia = hv.id_hocvien WHERE bv.id_baiviet = ?";
if (!$is_preview) {
    $sql_post .= " AND bv.trang_thai = 'da_duyet'";
}
$stmt = $conn->prepare($sql_post);
$stmt->bind_param("i", $id_baiviet);
$stmt->execute();
$result_post = $stmt->get_result();
$post = $result_post->fetch_assoc();

if (!$post) {
    echo "<div class='container text-center my-5'><div class='alert alert-warning'>Bài viết không tồn tại hoặc chưa được duyệt.</div></div>";
    return;
}

// --- Lấy và sắp xếp bình luận ---
$sql_comments = "SELECT b.*, h.ten_hocvien FROM binh_luan b JOIN hocvien h ON b.id_hocvien = h.id_hocvien WHERE b.id_baiviet = ? ORDER BY b.ngay_tao ASC";
$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param("i", $id_baiviet);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();

$comments = [];
while ($row = $result_comments->fetch_assoc()) {
    $comments[] = $row;
}
$total_comments = count($comments);

// Tạo cây bình luận
$comments_by_id = [];
foreach ($comments as $comment) {
    $comments_by_id[$comment['id_binhluan']] = $comment;
    $comments_by_id[$comment['id_binhluan']]['replies'] = [];
}
$comment_tree = [];
foreach ($comments_by_id as $id => &$comment) {
    if ($comment['parent_id'] && isset($comments_by_id[$comment['parent_id']])) {
        $comments_by_id[$comment['parent_id']]['replies'][] = &$comment;
    }
    if ($comment['parent_id'] === null) {
        $comment_tree[] = &$comment;
    }
}
unset($comment);

// Lấy thông tin người dùng hiện tại để phân quyền
$current_user_id = $_SESSION['id_hocvien'] ?? null;
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

// Hàm đệ quy để hiển thị bình luận
function render_comments($comments, $current_user_id, $is_admin, $is_reply = false)
{
    $html = '<div class="comment-list ' . ($is_reply ? 'replies' : '') . '">';
    foreach ($comments as $comment) {
        $author_name = htmlspecialchars($comment['ten_hocvien']);
        $can_delete = $is_admin || ($current_user_id && $current_user_id == $comment['id_hocvien']);
        $delete_button_html = $can_delete
            ? '<button class="btn-delete" onclick="deleteComment(' . $comment['id_binhluan'] . ')" title="Xóa bình luận"><i class="fas fa-trash-alt"></i></button>'
            : '';

        $html .= '
            <div class="comment-item" id="comment-' . $comment['id_binhluan'] . '" data-aos="fade-up">
                <div class="comment-avatar">
                    <img src="https://ui-avatars.com/api/?name=' . urlencode($comment['ten_hocvien']) . '&background=0db33b&color=fff&font-size=0.5" alt="' . $author_name . '">
                </div>
                <div class="comment-body">
                    <div class="comment-header">
                        <span class="author-name">' . $author_name . '</span>
                        <span class="comment-date">' . date("H:i, d/m/Y", strtotime($comment['ngay_tao'])) . '</span>
                    </div>
                    <p class="comment-text">' . nl2br(htmlspecialchars($comment['noi_dung'])) . '</p>
                    <div class="comment-actions">
                        <button class="btn-reply" onclick="showReplyForm(' . $comment['id_binhluan'] . ', \'' . addslashes($author_name) . '\')">
                            <i class="fas fa-reply"></i> Trả lời
                        </button>
                        ' . $delete_button_html . '
                    </div>
                    <div class="reply-form-container" id="reply-form-' . $comment['id_binhluan'] . '"></div>';

        if (!empty($comment['replies'])) {
            $html .= render_comments($comment['replies'], $current_user_id, $is_admin, true);
        }

        $html .= '</div></div>';
    }
    $html .= '</div>';
    return $html;
}
?>

<div class="final-blog-single-page">
    <div class="post-hero-header" style="background-image: url('<?php echo htmlspecialchars($post['hinh_anh_tieu_de'] ?? 'https://img.freepik.com/free-photo/learning-education-ideas-insight-intelligence-study-concept_53876-120116.jpg'); ?>');" data-aos="fade-in">
        <div class="overlay"></div>
        <div class="container content">
            <h1 class="post-title-main"><?php echo htmlspecialchars($post['tieu_de']); ?></h1>
            <div class="post-meta-main">
                <span><i class="fas fa-user"></i> <strong><?php echo htmlspecialchars($post['ten_hocvien'] ?? 'Admin'); ?></strong></span>
                <span><i class="fas fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($post['ngay_duyet'] ?? $post['ngay_tao'])); ?></span>
                <span><i class="fas fa-eye"></i> <?php echo $post['luot_xem']; ?> lượt xem</span>
            </div>
        </div>
    </div>

    <div class="main-content-area">
        <div class="container">
            <div class="row gx-lg-5">
                <div class="col-lg-8">
                    <article class="post-content-wrapper" data-aos="fade-up">
                        <?php echo $post['noi_dung']; ?>
                    </article>

                    <div class="comment-section-wrapper" id="comment-section" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="section-title"><i class="fas fa-comments"></i> Bình luận (<?php echo $total_comments; ?>)</h3>

                        <?php if (isset($_SESSION['id_hocvien'])): ?>
                            <form id="main-comment-form" class="main-comment-form">
                                <input type="hidden" name="id_baiviet" value="<?php echo $id_baiviet; ?>">
                                <div class="mb-3">
                                    <textarea name="noi_dung" class="form-control" placeholder="Viết bình luận của bạn..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-submit-comment">Gửi bình luận</button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-info">Vui lòng <a href="index.php?nav=login" class="fw-bold text-decoration-underline">đăng nhập</a> để tham gia bình luận.</div>
                        <?php endif; ?>

                        <div id="comments-container" class="mt-4">
                            <?php
                            if (!empty($comment_tree)) {
                                echo render_comments($comment_tree, $current_user_id, $is_admin);
                            } else {
                                echo "<p class='text-muted mt-4'>Chưa có bình luận nào. Hãy là người đầu tiên!</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
                            <h4 class="widget-title">Tìm kiếm bài viết</h4>
                            <form method="GET" action="index.php" class="sidebar-search-form">
                                <input type="hidden" name="nav" value="blog">
                                <input type="text" name="blog_search" placeholder="Nhập từ khóa...">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>

                        <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="200">
                            <h4 class="widget-title">Bài viết gần đây</h4>
                            <ul class="recent-posts-list">
                                <?php
                                $sql_recent = "SELECT id_baiviet, tieu_de, ngay_duyet, hinh_anh_tieu_de FROM bai_viet WHERE trang_thai = 'da_duyet' AND id_baiviet != ? ORDER BY ngay_duyet DESC LIMIT 4";
                                $stmt_recent = $conn->prepare($sql_recent);
                                $stmt_recent->bind_param("i", $id_baiviet);
                                $stmt_recent->execute();
                                $result_recent = $stmt_recent->get_result();

                                if ($result_recent->num_rows > 0):
                                    while ($recent_post = $result_recent->fetch_assoc()):
                                ?>
                                        <li>
                                            <a href="index.php?nav=blog_single&id=<?php echo $recent_post['id_baiviet']; ?>">
                                                <img src="<?php echo htmlspecialchars($recent_post['hinh_anh_tieu_de'] ?? 'https://via.placeholder.com/80'); ?>" alt="<?php echo htmlspecialchars($recent_post['tieu_de']); ?>">
                                                <div class="post-info">
                                                    <p class="title"><?php echo htmlspecialchars($recent_post['tieu_de']); ?></p>
                                                    <span class="date"><?php echo date("d/m/Y", strtotime($recent_post['ngay_duyet'])); ?></span>
                                                </div>
                                            </a>
                                        </li>
                                <?php endwhile;
                                endif;
                                $stmt_recent->close(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ==========================================================
   CSS HOÀN TOÀN ĐỘC LẬP CHO TRANG CHI TIẾT BLOG
   ========================================================== */
    .final-blog-single-page {
        --brand-color: #0db33b;
        --brand-color-dark: #0a8a2c;
        --text-dark: #212529;
        --text-light: #555;
        --white: #fff;
        --bg-light: #f8f9fa;
        --border-color: #e9ecef;
    }

    .final-blog-single-page {
        background-color: var(--bg-light);
    }

    /* --- Hero Header --- */
    .final-blog-single-page .post-hero-header {
        position: relative;
        padding: 80px 0;
        color: var(--white);
        background-size: cover;
        background-position: center;
        text-align: center;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .final-blog-single-page .post-hero-header .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
    }

    .final-blog-single-page .post-hero-header .content {
        position: relative;
        z-index: 2;
    }

    .final-blog-single-page .post-title-main {
        font-size: 45px;
        font-weight: 700;
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        margin-bottom: 20px;
    }

    .final-blog-single-page .post-meta-main {
        display: flex;
        justify-content: center;
        gap: 25px;
        font-size: 20px;
        opacity: 0.9;
    }

    /* --- Main Content --- */
    .final-blog-single-page .main-content-area {
        padding: 30px 0;
    }

    .final-blog-single-page .post-content-wrapper {
        background: var(--white);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
        font-size: 17px;
        line-height: 1.8;
        color: var(--text-light);
    }

    .final-blog-single-page .post-content-wrapper img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 25px 0;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .final-blog-single-page .post-content-wrapper h2,
    .post-content-wrapper h3,
    .post-content-wrapper h4 {
        font-weight: 700;
        color: var(--text-dark);
        margin-top: 30px;
        margin-bottom: 15px;
        border-left: 4px solid var(--brand-color);
        padding-left: 15px;
    }

    .final-blog-single-page .post-content-wrapper blockquote {
        background: #f1f8ff;
        border-left: 5px solid #007bff;
        margin: 20px 0;
        padding: 20px;
        font-style: italic;
        color: #004085;
    }

    /* --- Comment Section --- */
    .final-blog-single-page .comment-section-wrapper {
        margin-top: 50px;
        background: var(--white);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
    }

    .final-blog-single-page .section-title {
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 26px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--brand-color-dark);
    }

    .final-blog-single-page .main-comment-form textarea {
        min-height: 120px;
        resize: vertical;
        border-radius: 8px;
        font-size: 15px;
    }

    .final-blog-single-page .btn-submit-comment {
        background: var(--brand-color);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .final-blog-single-page .btn-submit-comment:hover {
        background: var(--brand-color-dark);
        transform: translateY(-2px);
    }

    .final-blog-single-page .comment-list {
        padding: 0;
    }

    .final-blog-single-page .comment-item {
        display: flex;
        gap: 15px;
        margin-top: 25px;
    }

    .final-blog-single-page .comment-avatar img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
    }

    .final-blog-single-page .comment-body {
        flex-grow: 1;
        background: var(--bg-light);
        padding: 15px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .final-blog-single-page .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .final-blog-single-page .author-name {
        font-weight: 600;
        color: var(--text-dark);
    }

    .final-blog-single-page .comment-date {
        font-size: 12px;
        color: var(--text-light);
    }

    .final-blog-single-page .comment-text {
        margin-bottom: 10px;
        font-size: 15px;
        line-height: 1.7;
        word-wrap: break-word;
    }

    .final-blog-single-page .comment-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .final-blog-single-page .btn-reply,
    .btn-delete {
        background: none;
        border: none;
        font-weight: 500;
        cursor: pointer;
        padding: 0;
        font-size: 13px;
        transition: color 0.2s;
    }

    .final-blog-single-page .btn-reply {
        color: #0d6efd;
    }

    .final-blog-single-page .btn-reply:hover {
        text-decoration: underline;
    }

    .final-blog-single-page .btn-reply i {
        margin-right: 4px;
    }

    .final-blog-single-page .btn-delete {
        color: #dc3545;
    }

    .final-blog-single-page .btn-delete:hover {
        color: #a71d2a;
    }

    .final-blog-single-page .replies {
        margin-top: 20px;
        padding-left: 25px;
        position: relative;
        border-left: 2px solid var(--border-color);
    }

    .final-blog-single-page .replies .comment-item {
        margin-top: 15px;
    }

    .final-blog-single-page .reply-form-container {
        margin-top: 15px;
    }

    .final-blog-single-page .reply-form textarea {
        font-size: 14px;
        min-height: 80px;
    }

    /* --- Sidebar --- */
    .final-blog-single-page .blog-sidebar {
        position: -webkit-sticky;
        position: sticky;
        top: 120px;
    }

    .final-blog-single-page .sidebar-widget {
        background: var(--white);
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
        margin-bottom: 30px;
    }

    .final-blog-single-page .widget-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
        position: relative;
    }

    .final-blog-single-page .widget-title::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--brand-color);
        border-radius: 2px;
    }

    .final-blog-single-page .sidebar-search-form {
        position: relative;
    }

    .final-blog-single-page .sidebar-search-form input {
        width: 100%;
        height: 45px;
        border-radius: 50px;
        border: 1px solid var(--border-color);
        padding: 0 50px 0 20px;
    }

    .final-blog-single-page .sidebar-search-form button {
        position: absolute;
        right: 5px;
        top: 5px;
        height: 35px;
        width: 35px;
        border-radius: 50%;
        border: none;
        background: var(--brand-color);
        color: var(--white);
    }

    .final-blog-single-page .recent-posts-list {
        list-style: none;
        padding: 0;
    }

    .final-blog-single-page .recent-posts-list li a {
        display: flex;
        gap: 15px;
        align-items: center;
        text-decoration: none;
        padding: 10px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .final-blog-single-page .recent-posts-list li a:hover {
        background: var(--bg-light);
    }

    .final-blog-single-page .recent-posts-list img {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
    }

    .final-blog-single-page .recent-posts-list .post-info .title {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 5px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .final-blog-single-page .recent-posts-list .post-info .date {
        font-size: 12px;
        color: var(--text-light);
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .final-blog-single-page .post-title-main {
            font-size: 32px;
        }

        .final-blog-single-page .main-content-area {
            padding-top: 40px;
        }

        .final-blog-single-page .blog-sidebar {
            margin-top: 40px;
        }
    }
</style>

<script>
    // Các script cũ của bạn vẫn hoạt động tốt, không cần thay đổi
    document.addEventListener('DOMContentLoaded', function() {
        const mainCommentForm = document.getElementById('main-comment-form');
        if (mainCommentForm) {
            mainCommentForm.addEventListener('submit', submitComment);
        }
    });

    function showReplyForm(commentId, usernameToReply) {
        document.querySelectorAll('.reply-form-container').forEach(container => container.innerHTML = '');
        const container = document.getElementById(`reply-form-${commentId}`);
        if (!container) return;

        <?php if (!isset($_SESSION['id_hocvien'])): ?>
            Swal.fire({
                title: 'Bạn chưa đăng nhập',
                text: "Vui lòng đăng nhập để trả lời bình luận.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đăng nhập ngay'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?nav=login';
                }
            })
            return;
        <?php endif; ?>

        const mention = `@${usernameToReply} `;
        const formHtml = `
        <form class="comment-form reply-form mt-2" onsubmit="submitComment(event)">
            <input type="hidden" name="id_baiviet" value="<?php echo $id_baiviet; ?>">
            <input type="hidden" name="parent_id" value="${commentId}">
            <div class="mb-2">
                <textarea name="noi_dung" class="form-control" placeholder="Trả lời ${usernameToReply}..." required>${mention}</textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Gửi</button>
            <button type="button" class="btn btn-sm btn-secondary" onclick="this.closest('.reply-form-container').innerHTML = ''">Hủy</button>
        </form>
    `;
        container.innerHTML = formHtml;
        const textarea = container.querySelector('textarea');
        textarea.focus();
        textarea.setSelectionRange(textarea.value.length, textarea.value.length);
    }

    function submitComment(event) {
        event.preventDefault();
        const form = event.target;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonHTML = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang gửi...';
        const formData = new FormData(form);

        fetch('pages/main/submit_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: 'Bình luận của bạn đã được gửi.',
                            timer: 2000,
                            showConfirmButton: false
                        })
                        .then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message || 'Có lỗi xảy ra.'
                    });
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonHTML;
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi kết nối',
                    text: 'Không thể gửi bình luận, vui lòng thử lại.'
                });
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonHTML;
            });
    }

    function deleteComment(commentId) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Hành động này sẽ xóa vĩnh viễn bình luận và không thể khôi phục!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Vâng, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('pages/main/delete_comment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            comment_id: commentId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const commentElement = document.getElementById(`comment-${commentId}`);
                            if (commentElement) {
                                commentElement.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                                commentElement.style.opacity = '0';
                                commentElement.style.transform = 'translateX(-20px)';
                                setTimeout(() => commentElement.remove(), 500);
                            }
                            Swal.fire('Đã xóa!', data.message, 'success');
                        } else {
                            Swal.fire('Lỗi!', data.message, 'error');
                        }
                    })
                    .catch(error => Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error'));
            }
        });
    }
</script>