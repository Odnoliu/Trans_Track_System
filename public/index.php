
<?php
    // public/index.php
    require __DIR__ . '/config/connect_databases.php';
    require __DIR__ . '/controller/auth_controller.php'; 

    $authController = new AuthController($pdo);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['action'])) {
        $error = $authController->login();
        if ($error) {
            header("Location: /auth/login.php?error=" . urlencode($error));
            exit;
        }
    } 
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'verify_otp') {
        $error = $authController->verifyOTP();
        if ($error) {
            require __DIR__ . '/auth/verify_otp.php';  // Hiển thị lỗi OTP nếu thất bại
        }
    } 
    else {
        require __DIR__ . '/auth/login.php';
    }
?>