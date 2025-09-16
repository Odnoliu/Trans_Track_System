<?php
session_start();
class OrderController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy tất cả đơn hàng
    public function getAllOrders() {
        $stmt = $this->pdo->query("
            SELECT 
                DH_Ma AS id,
                DH_MaQR AS qr_code,
                DH_SoLuongKIH AS so_luong_kien,
                DH_TongTien AS tong_tien,
                DH_ToaDoDi AS toa_do_di,
                DH_ToaDoDen AS toa_do_den,
                DH_GhiChu AS ghi_chu,
                KH_ID AS khach_hang,
                NVGH_Ma AS nhan_vien_giao,
                NCC_ID AS nha_cung_cap,
                TT_Ma AS trang_thai,
                K_Ma AS kho
            FROM donhang
            WHERE KH_ID = ?
        ");
        $stmt->execute([$_SESSION['username']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
