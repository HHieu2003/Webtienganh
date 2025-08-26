
<?php
include('../config/config.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['id_hocvien'])) {
    die("Bạn cần đăng nhập để cập nhật thông tin.");
}

$id_hocvien = $_SESSION['id_hocvien'];

$sql_course = "SELECT * FROM hocvien WHERE id_hocvien = ?";
    $stmt = $conn->prepare($sql_course);
    $stmt->bind_param("i", $id_hocvien);
    $stmt->execute();
    $result_course = $stmt->get_result();

    // Kiểm tra nếu khóa học tồn tại
    if ($result_course->num_rows > 0) {
        $course = $result_course->fetch_assoc();
    } 
// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_hocvien = trim($_POST['ten_hocvien']);
    $so_dien_thoai = trim($_POST['so_dien_thoai']);

    // Kiểm tra dữ liệu hợp lệ
    if (empty($ten_hocvien) || empty($so_dien_thoai)) {
        echo "<div class='alert alert-danger'>Tên và số điện thoại không được để trống.</div>";
        exit;
    }

    // if (!preg_match('/^[0-9]{10,15}$/', $so_dien_thoai)) {
    //     echo "<div class='alert alert-danger'>Số điện thoại không hợp lệ. Vui lòng nhập 10-15 chữ số.</div>";
    //     exit;
    // }

    // Cập nhật thông tin trong cơ sở dữ liệu
    $sql = "UPDATE hocvien SET ten_hocvien = ?, so_dien_thoai = ? WHERE id_hocvien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $ten_hocvien, $so_dien_thoai, $id_hocvien);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Thông tin đã được cập nhật thành công!</div>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<div class="account-right">
    <h2>Thông tin tài khoản</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="first-name">Họ và Tên của Bạn</label>
            <input type="text" name="ten_hocvien" id="first-name" placeholder="Họ và Tên" value="<?php echo $course['ten_hocvien']; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Điện thoại</label>
            <input type="text" name="so_dien_thoai" id="phone" placeholder="Số điện thoại" value="<?php echo $course['so_dien_thoai']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" placeholder="abc@gmail.com" value="<?php echo $course['email']; ?>" readonly>
            <span class="verified">Verified ✔</span>
        </div>
        <div class="form-group">
            <label for="about">Giới thiệu về Bạn</label>
            <textarea id="about" placeholder="mô tả"></textarea>
        </div>
      
        <div class="form-group">
            <label for="gender">Giới tính</label>
            <select id="gender">
                <option>Nam</option>
                <option>Nữ</option>
                <option>Khác</option>
            </select>
        </div>
         <button class="btn-save btn btn-primary mt-3" type="submit">Save</button>

    </form>
</div>

<style>
    .account-right {
        flex: 3;
        background-color: #ffff;
        padding: 20px;
        border-radius: 8px;
        gap: 20px;

    }

    .account-right h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #0db33b;
    }

    .form-group {
        margin-bottom: 15px;
        width: 70%;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-group input[readonly] {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    .form-group textarea {
        height: 80px;
        resize: none;
    }

    .form-group-1 {
        display: flex;
        gap: 10px;
    }

    .form-group .verified {
        color: #28a745;
        font-weight: bold;
    }

    .avatar {
        text-align: left;
        margin-left: 30px;
        margin-bottom: 20px;
    }

    .avatar img {
        height: 100px;
        border-radius: 50%;
        background-color: #d9f99d;
        font-size: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
    }

    .btn-save {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
    }

    .btn-save:hover {
        background-color: #7be998;
    }
</style>