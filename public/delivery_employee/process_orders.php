<?php
// proccess_orders.php
include("../navbar.php");
require_once("../config/connect_databases.php");

// Lấy đơn hàng đã giao (TT004)
try {
    $stmt = $pdo->prepare("
        SELECT DH_Ma, DH_GhiChu, DH_TongTien, KH_ID 
        FROM donhang 
        WHERE NVGH_Ma = 'NV001' AND TT_Ma = 'TT004'
        ORDER BY DH_Ma DESC
    ");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Lỗi truy vấn DB: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử giao hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold text-purple-700 mb-6">Lịch sử các đơn hàng đã giao</h1>

        <?php if (empty($orders)): ?>
            <p class="text-gray-600">Không có đơn hàng nào trong lịch sử.</p>
        <?php else: ?>
            <table class="w-full bg-white shadow rounded-lg overflow-hidden">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Mã đơn</th>
                        <th class="px-4 py-2 text-left">Ghi chú</th>
                        <th class="px-4 py-2 text-left">Tổng tiền</th>
                        <th class="px-4 py-2 text-left">Khách hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?= htmlspecialchars($order['DH_Ma']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($order['DH_GhiChu']) ?></td>
                            <td class="px-4 py-2"><?= number_format($order['DH_TongTien'], 0, ',', '.') ?> đ</td>
                            <td class="px-4 py-2"><?= htmlspecialchars($order['KH_ID']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
