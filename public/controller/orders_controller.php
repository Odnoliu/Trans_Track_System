<?php
session_start();
class OrderController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy tất cả đơn hàng
    public function getAllOrders() {
        $stmt = $this->pdo->prepare("
            SELECT 
                DH_Ma AS id
            FROM donhang dh
            JOIN khachhang kh ON dh.KH_ID = kh.KH_ID
            JOIN taikhoan tk ON kh.TK_ID = tk.TK_ID
            WHERE tk.TK_TenDangNhap = ?
        ");
        $stmt->execute([$_SESSION['username']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
