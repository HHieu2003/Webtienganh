<style>
    .account-right {
        flex: 3;
        background-color: #ffff;
        padding: 20px;
        border-radius: 8px;
        height: 100%;
    }

    .account-right h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #0db33b;
    }

    .form-group {
        margin-bottom: 15px;
        width: 500px;
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
<?php
include('../config/config.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['id_hocvien'])) {
    die("Bạn cần đăng nhập để thay đổi mật khẩu.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu mới và xác nhận mật khẩu
    if ($new_password !== $confirm_password) {
        echo "<div class='alert alert-danger'>Mật khẩu xác nhận không khớp!</div>";
        exit;
    }

    // Kiểm tra độ mạnh của mật khẩu mới (tuỳ chọn)
    // if (strlen($new_password) < 8) {
    //     echo "<div class='alert alert-danger'>Mật khẩu mới phải có ít nhất 8 ký tự.</div>";
    //     exit;
    // }

    // Lấy mật khẩu cũ từ cơ sở dữ liệu
    $sql = "SELECT mat_khau FROM hocvien WHERE id_hocvien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_hocvien);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $hashed_password = $row['mat_khau'];

        // Kiểm tra mật khẩu cũ có đúng không
        if ($old_password !== $hashed_password) {
            echo "<div class='alert alert-danger'>Mật khẩu cũ không đúng!</div>";

            exit;
        }

        // Mã hóa mật khẩu mới
        //   $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu trong cơ sở dữ liệu
        $sql_update = "UPDATE hocvien SET mat_khau = ? WHERE id_hocvien = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $new_password, $id_hocvien);

        if ($stmt_update->execute()) {
            echo "<div class='alert alert-success'>Mật khẩu đã được thay đổi thành công!</div>";
           
            exit;
        } else {
            echo "<div class='alert alert-danger'>Có lỗi xảy ra. Vui lòng thử lại sau.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Không tìm thấy thông tin người dùng.</div>";
    }

    $stmt->close();

}

$conn->close();
?>


<div class="account-right">
    <h2>Thay đổi mật khẩu</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="old_password">Mật khẩu cũ</label>
            <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Nhập mật khẩu cũ" required>
        </div>
        <div class="form-group">
            <label for="new_password">Mật khẩu mới</label>
            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Nhập mật khẩu mới" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Xác nhận mật khẩu mới</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu mới" required>
        </div>
        <button class="btn-save btn btn-primary mt-3" type="submit">Cập Nhật</button>
    </form>
</div>