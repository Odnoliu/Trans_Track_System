
<?php
    // public/index.php
    require __DIR__ . '/config/connect_databases.php';
    require __DIR__ . '/controller/auth_controller.php'; 

    $authController = new AuthController($pdo);

    // Debug URI (bỏ comment để debug, xóa sau khi test)
    // echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";

    // Xử lý login (POST từ login.php)
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['action'])) {
        $error = $authController->login();
        if ($error) {
            header("Location: /auth/login.php?error=" . urlencode($error));
            exit;
        }
    } 
    // Xử lý verify OTP (POST từ verify_otp.php)
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'verify_otp') {
        $error = $authController->verifyOTP();
        if ($error) {
            require __DIR__ . '/auth/verify_otp.php';  // Hiển thị lỗi OTP nếu thất bại
        }
    } 
    // Hiển thị trang login mặc định nếu không phải POST
    else {
        require __DIR__ . '/auth/login.php';
    }
?>