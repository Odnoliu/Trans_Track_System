<?php
session_start();
require '../vendor/autoload.php';  // Sử dụng autoload từ Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                return "Vui lòng nhập đầy đủ thông tin!";
            }

            try {
                $stmt = $this->pdo->prepare("
                    SELECT TK_ID, TK_MatKhau, VT_Ma, TK_TenDangNhap
                    FROM taikhoan 
                    WHERE TK_TenDangNhap = ?
                ");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && ($password == $user['TK_MatKhau'])) {  // Sửa so sánh mật khẩu
                    $_SESSION['username'] = $user['TK_TenDangNhap'];
                    $_SESSION['role'] = $user['VT_Ma'];

                    // Chỉ áp dụng OTP cho vai trò khách hàng (VT003)
                    if ($user['VT_Ma'] === 'VT003') {
                        $stmtCustomer = $this->pdo->prepare("
                            SELECT KH_Email, KH_SDT 
                            FROM khachhang 
                            WHERE TK_ID = ?  
                        ");
                        $stmtCustomer->execute([$user['TK_ID']]);
                        $customer = $stmtCustomer->fetch(PDO::FETCH_ASSOC);

                        if ($customer && !empty($customer['KH_Email']) && !empty($customer['KH_SDT'])) {
                            $otp = rand(100000, 999999);
                            $_SESSION['otp'] = $otp;
                            $_SESSION['otp_time'] = time() + 300;  // Hết hạn sau 5 phút
                            $_SESSION['temp_username'] = $user['TK_TenDangNhap'];

                            $this->sendEmailOTP($customer['KH_Email'], $otp);

                            $this->sendSMSOTP($customer['KH_SDT'], $otp);
                            
                            header("Location: /auth/verify_otp.php");
                            exit;
                        } else {
                            return "Không tìm thấy email hoặc số điện thoại của khách hàng!";
                        }
                    } else {
                        // Điều hướng trực tiếp cho các vai trò khác
                        switch ($user['VT_Ma']) {
                            case 'VT001':
                                header("Location: /admin/admin.php");
                                exit;
                            case 'VT004':
                                header("Location: /provider/provider.php");
                                exit;
                            case 'VT002':
                                header("Location: /employee/employee.php");
                                exit;
                            default:
                                header("Location: /auth/login.php");
                                exit;
                        }
                    }
                } else {
                    return "Tên đăng nhập hoặc mật khẩu không đúng!";
                }
            } catch (PDOException $e) {
                return "Lỗi kết nối CSDL: " . $e->getMessage();
            }
        }
        return null;
    }

    private function sendEmailOTP($email, $otp) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hongphuccaowork@gmail.com';  // Thay bằng email Gmail của bạn
            $mail->Password = 'xfaj qhmx wici witk';  // App Password từ Gmail; KHÔNG ĐƯỢC XÓA NHÉ
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('hongphuccaowork@gmail.com', 'LogiX System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Mã OTP Xác Thực Đăng Nhập';
            $mail->Body = "Mã OTP của bạn là: <b>$otp</b>. Mã này hết hạn sau 5 phút.";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email OTP failed: " . $mail->ErrorInfo);
        }
    }
    // Y666X1YBDGH9QM3S3X4297WU (KHÔNG ĐƯỢC XÓA NHÉ)
    private function sendSMSOTP($phone, $otp) {
    $apiKey = 'QOZysqzi9Ozax3lyYqT1k6tzHuv4H9k3';  // Lấy từ dashboard SpeedSMS
    $message = "Mã OTP của bạn là: $otp. Hết hạn sau 5 phút.";
    $url = "https://api.speedsms.vn/index.php/sms/send";

    $data = array(
        'to' => $phone,  // +84372807xxx hoặc 84372807xxx
        'content' => $message,
        'api_key' => $apiKey
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {
        error_log("SpeedSMS OTP failed: Kết nối thất bại");
    } else {
        $response = json_decode($result, true);
        if (isset($response['code']) && $response['code'] !== 200) {  // 200 là thành công
            error_log("SpeedSMS OTP failed: " . ($response['message'] ?? 'Unknown error'));
        } else {
            error_log("SpeedSMS OTP sent successfully");
        }
    }
}

    public function verifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'verify_otp') {
            $enteredOTP = $_POST['otp'] ?? '';
            $username = $_POST['username'] ?? '';

            if (empty($enteredOTP)) {
                return "Vui lòng nhập mã OTP!";
            }

            if (isset($_SESSION['otp']) && isset($_SESSION['otp_time']) && time() < $_SESSION['otp_time']) {
                if ($enteredOTP == $_SESSION['otp']) {
                    $_SESSION['logged_in'] = true;

                    // Xóa OTP sau khi dùng
                    unset($_SESSION['otp']);
                    unset($_SESSION['otp_time']);
                    unset($_SESSION['temp_username']);
                    header("Location: /customer/customer.php");
                } else {
                    return "Mã OTP không đúng!";
                }
            } else {
                return "Mã OTP hết hạn hoặc không hợp lệ!";
            }
        }
        return null;
    }
}
?>