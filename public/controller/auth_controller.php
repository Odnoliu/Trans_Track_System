<?php
// LƯU Ý: file này cần xem lại mã vai trò, hash password để có thể chạy
session_start();
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
                    SELECT TK_ID, TK_MatKhau, VT_Ma 
                    FROM taikhoan 
                    WHERE TK_TenDangNhap = ?
                ");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "Mat khau: " . $user['TK_MatKhau'];     
                echo "Pw verify" . password_verify($password, $user['TK_MatKhau']);
                if ($user && ($password == $user['TK_MatKhau'])) {
                    // Lưu session
                    $_SESSION['username'] = $user['TK_TenDangNhap'];
                    $_SESSION['role'] = $user['VT_Ma'];

                    // Điều hướng dựa trên role
                    switch ($user['VT_Ma']) {
                        case 'VT001':
                            header("Location: /admin/admin.php");
                            exit;
                        case 'VT003':
                            header("Location: /customer/customer.php");
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
                } else {
                    return "Tên đăng nhập hoặc mật khẩu không đúng!";
                }
            } catch (PDOException $e) {
                return "Lỗi kết nối CSDL: " . $e->getMessage();
            }
        }
        return null;
    }
}
?>