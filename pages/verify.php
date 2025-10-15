<?php
session_start();
include("../config/config.php");

$message = '';
$message_type = 'info'; 
$email_from_url = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';

// Xử lý khi người dùng nhấn link hoặc submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['code'])) {
    
    $email = $_POST['email'] ?? $_GET['email'] ?? '';
    $code = $_POST['verification_code'] ?? $_GET['code'] ?? '';

    if (empty($email) || empty($code)) {
        $message = "Vui lòng nhập email và mã xác thực.";
        $message_type = 'danger';
    } else {
        $stmt = $conn->prepare("SELECT id_hocvien, token_expiry FROM hocvien WHERE email = ? AND verification_token = ? AND is_verified = 0");
        $stmt->bind_param("ss", $email, $code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (strtotime($user['token_expiry']) > time()) {
                // Kích hoạt tài khoản
                $update_stmt = $conn->prepare("UPDATE hocvien SET is_verified = 1, verification_token = NULL, token_expiry = NULL WHERE id_hocvien = ?");
                $update_stmt->bind_param("i", $user['id_hocvien']);
                if ($update_stmt->execute()) {
                    $message = "Xác thực email thành công! Bạn sẽ được chuyển đến trang đăng nhập sau 3 giây.";
                    $message_type = 'success';
                    header("refresh:3;url=login.php");
                } else {
                    $message = "Lỗi: Không thể cập nhật trạng thái tài khoản.";
                    $message_type = 'danger';
                }
            } else {
                $message = "Lỗi: Mã xác thực đã hết hạn. Vui lòng thử đăng ký lại.";
                $message_type = 'danger';
            }
        } else {
            $message = "Lỗi: Email hoặc mã xác thực không đúng.";
            $message_type = 'danger';
        }
        $stmt->close();
    }
} else if (!empty($email_from_url)) {
    $message = "Một mã xác thực đã được gửi đến <strong>" . $email_from_url . "</strong>. Vui lòng nhập mã để kích hoạt tài khoản.";
} else {
    $message = "Yêu cầu không hợp lệ.";
    $message_type = 'danger';
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác thực tài khoản - Tiếng Anh Fighter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Times New Roman', Times, serif; }
        .verify-container { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .verify-box { max-width: 450px; width: 100%; padding: 40px; background: white; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); text-align: center; }
        .verify-box h2 { font-weight: 700; color: #0db33b; margin-bottom: 15px; }
        .code-inputs { display: flex; justify-content: center; gap: 10px; margin: 30px 0; }
        .code-inputs input { width: 50px; height: 60px; text-align: center; font-size: 24px; font-weight: bold; border: 1px solid #ddd; border-radius: 8px; transition: all 0.2s ease; }
        .code-inputs input:focus { border-color: #0db33b; box-shadow: 0 0 0 4px rgba(13, 179, 59, 0.2); outline: none; }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="verify-box">
            <i class="fa-solid fa-envelope-circle-check fa-3x text-success mb-3"></i>
            <h2>Xác thực tài khoản</h2>
            
            <?php if (!empty($message)) : ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($message_type !== 'success' && !empty($email_from_url)): ?>
            <form method="POST" action="verify.php" id="verify-form">
                <input type="hidden" name="email" value="<?php echo $email_from_url; ?>">
                <p>Nhập mã 6 số được gửi đến email của bạn:</p>
                <div class="code-inputs" id="code-inputs">
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                </div>
                <input type="hidden" name="verification_code" id="verification_code">
                <button type="submit" class="btn btn-primary w-100 btn-lg">Xác thực</button>
            </form>
            <div class="mt-3">
                <a href="register.php">Quay lại trang Đăng ký</a>
            </div>
            <?php elseif ($message_type === 'success'): ?>
                <a href="login.php" class="btn btn-primary">Đi đến trang Đăng nhập ngay</a>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        const inputsContainer = document.getElementById('code-inputs');
        if (inputsContainer) {
            const hiddenInput = document.getElementById('verification_code');
            const form = document.getElementById('verify-form');
            const inputs = Array.from(inputsContainer.children);

            const updateHiddenInput = () => {
                let code = '';
                inputs.forEach(input => {
                    code += input.value;
                });
                hiddenInput.value = code;
            };

            inputs.forEach((input, index) => {
                // Xử lý khi nhập liệu
                input.addEventListener('input', (e) => {
                    // Chỉ cho phép nhập số
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                    
                    // Tự động chuyển sang ô tiếp theo nếu đã nhập
                    if (e.target.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateHiddenInput();
                });

                // Xử lý các phím điều hướng
                input.addEventListener('keydown', (e) => {
                    // Khi nhấn Backspace, nếu ô hiện tại trống thì lùi về ô trước
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        e.preventDefault();
                        inputs[index - 1].focus();
                    }
                    // Di chuyển sang trái bằng phím mũi tên
                    if (e.key === 'ArrowLeft' && index > 0) {
                        inputs[index - 1].focus();
                    }
                    // Di chuyển sang phải bằng phím mũi tên
                    if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                // Xử lý khi dán (paste)
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
                    // Chỉ xử lý nếu dữ liệu dán vào là chuỗi 6 số
                    if (/^\d{6}$/.test(pasteData)) {
                        pasteData.split('').forEach((char, i) => {
                            if (inputs[i]) {
                                inputs[i].value = char;
                            }
                        });
                        updateHiddenInput();
                        if (form) {
                            // Tự động submit form sau khi dán
                            form.submit();
                        }
                    }
                });
            });
        }
    </script>
</body>
</html>