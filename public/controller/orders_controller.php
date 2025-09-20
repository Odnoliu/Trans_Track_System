<?php
session_start();
class OrderController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy tất cả đơn hàng
public function getAllOrdersByUser() {
    $stmt = $this->pdo->prepare("
        SELECT 
            dh.DH_Ma,
            dh.DH_MaQR,
            dh.DH_SoLuongKIH,
            dh.DH_TongTien,
            dh.DH_ToaDoDi,
            dh.DH_ToaDoDen,
            dh.DH_GhiChu,
            dh.KH_ID,
            dh.NVGH_Ma,
            dh.NCC_ID,
            dh.TT_Ma,
            dh.K_Ma,
            kh.KH_Ten,
            dc.DC_SoNha,
            dc.DC_ToaDo
        FROM donhang dh
        JOIN khachhang kh ON dh.KH_ID = kh.KH_ID
        JOIN taikhoan tk ON kh.TK_ID = tk.TK_ID
        LEFT JOIN diachi dc ON dc.KH_ID = kh.KH_ID
        WHERE tk.TK_TenDangNhap = ?
        ORDER BY dh.DH_Ma ASC
    ");
    $stmt->execute([$_SESSION['username']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function getAllOrders() {
        $stmt = $this->pdo->query("
            SELECT *
            FROM donhang
            ORDER BY DH_Ma ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
