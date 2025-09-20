<?php
// confirm_delivery.php
include("../navbar.php");
require_once("../config/connect_databases.php");

// Nếu bấm nút xác nhận giao thành công
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dh_ma'])) {
    try {
        $update = $pdo->prepare("UPDATE donhang SET TT_Ma = 'TT003' WHERE DH_Ma = ?");
        $update->execute([$_POST['dh_ma']]);
    } catch (Exception $e) {
        die("Lỗi cập nhật DB: " . $e->getMessage());
    }
}

// Lấy đơn hàng đang giao (TT002)
try {
    $stmt = $pdo->prepare("
        SELECT DH_Ma, DH_GhiChu, DH_ToaDoDen 
        FROM donhang 
        WHERE NVGH_Ma = 'NV001' AND TT_Ma = 'TT002'
        ORDER BY DH_Ma ASC
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
    <title>Xác nhận giao hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold text-green-700 mb-6">Đơn hàng đang giao (chờ xác nhận)</h1>

        <?php if (empty($orders)): ?>
            <p class="text-gray-600">Không có đơn hàng nào đang giao.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($orders as $order): ?>
                    <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
                        <div>
                            <p><strong>Mã đơn:</strong> <?= htmlspecialchars($order['DH_Ma']) ?></p>
                            <p><strong>Ghi chú:</strong> <?= htmlspecialchars($order['DH_GhiChu']) ?></p>
                            <a href="/map/customer_map.php" 
                               target="_blank" class="text-blue-600 underline">📍 Bản đồ</a>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="dh_ma" value="<?= htmlspecialchars($order['DH_Ma']) ?>">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                ✅ Xác nhận đã giao
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
