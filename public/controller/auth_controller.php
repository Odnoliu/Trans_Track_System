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
                    WHERE TK_ID = ?
                ");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['TK_MatKhau'])) {
                    // Lưu session
                    $_SESSION['username'] = $user['TK_ID'];
                    $_SESSION['role'] = $user['VT_Ma'];

                    // Điều hướng dựa trên role
                    switch ($user['VT_Ma']) {
                        case 'ADMIN':
                            header("Location: /admin/admin");
                            exit;
                        case 'CUSTOMER':
                            header("Location: /customer/customer");
                            exit;
                        case 'PROVIDER':
                            header("Location: /provider/provider");
                            exit;   
                        case 'EMPLOYEE':
                            header("Location: /employee/employee");
                            exit;     
                        default:
                            header("Location: /default/page");
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