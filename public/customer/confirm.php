<?php
// received_orders.php
include("../navbar.php");
// Kết nối database
require_once("../config/connect_databases.php");

// Nếu người dùng bấm nút "Đã nhận hàng"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dh_ma'])) {
    try {
        $update = $pdo->prepare("UPDATE donhang SET TT_Ma = 'TT004' WHERE DH_Ma = ?");
        $update->execute([$_POST['dh_ma']]);
    } catch (Exception $e) {
        die("Lỗi cập nhật DB: " . $e->getMessage());
    }
}

// Lấy danh sách đơn hàng trạng thái TT003
try {
    $stmt = $pdo->prepare("
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
        WHERE tk.TK_TenDangNhap = ? AND dh.TT_Ma = 'TT003'
        ORDER BY dh.DH_Ma ASC
    ");
    $stmt->execute([$_SESSION['username']]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Lỗi truy vấn DB: " . $e->getMessage());
}

// Tạo ngày nhận hàng giả lập
function fakeReceiveDate()
{
    $daysAgo = rand(0, 7);
    return date("d/m/Y", strtotime("-$daysAgo days"));
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đơn hàng đã nhận</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            opacity: 0;
            animation: fadeInUp .5s ease forwards;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-green-700 mb-6">Danh sách đơn hàng đang chờ xác nhận nhận hàng</h1>

        <?php if (empty($orders)): ?>
            <p class="text-gray-600">Hiện không có đơn hàng nào cần xác nhận.</p>
        <?php else: ?>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($orders as $index => $order): ?>
                    <article
                        class="bg-white rounded-2xl shadow p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl animate-fadeInUp"
                        style="animation-delay: <?= $index * 0.15 ?>s">
                        <h2 class="text-lg font-semibold text-gray-800">Mã đơn: <?= htmlspecialchars($order['DH_Ma']) ?></h2>
                        <p class="text-sm text-gray-600">Khách hàng: <?= htmlspecialchars($order['KH_Ten']) ?></p>
                        <p class="text-sm text-gray-600">Số lượng: <?= (int)$order['DH_SoLuongKIH'] ?></p>
                        <p class="text-sm text-gray-600">
                            Tổng tiền: <?= number_format($order['DH_TongTien'], 0, ',', '.') ?> đ
                        </p>
                        <p class="text-sm text-gray-700 mt-2">
                            Ngày giao dự kiến: <span class="font-semibold"><?= fakeReceiveDate() ?></span>
                        </p>

                        <!-- Form nút Đã nhận hàng -->
                        <form method="POST" class="mt-4">
                            <input type="hidden" name="dh_ma" value="<?= htmlspecialchars($order['DH_Ma']) ?>">
                            <button type="submit"
                                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition">
                                ✅ Đã nhận hàng
                            </button>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
