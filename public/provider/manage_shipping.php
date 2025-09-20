<?php
// Giả lập dữ liệu đơn hàng DH0000001 -> DH0000005
$orders = [
    ["DH_Ma" => "DH0000001", "DH_GhiChu" => "Giao buổi sáng", "TT_Ma" => "TT001"],
    ["DH_Ma" => "DH0000002", "DH_GhiChu" => "Khách hẹn giao chiều", "TT_Ma" => "TT002"],
    ["DH_Ma" => "DH0000003", "DH_GhiChu" => "Giao tại Smart Locker", "TT_Ma" => "TT003"],
    ["DH_Ma" => "DH0000004", "DH_GhiChu" => "Khách vắng mặt lần 1", "TT_Ma" => "TT005"],
    ["DH_Ma" => "DH0000005", "DH_GhiChu" => "Khách đã nhận đủ hàng", "TT_Ma" => "TT004"],
];

// Trạng thái + style
function getStatusConfig($code) {
    $configs = [
        'TT001' => ['label' => 'Đang Chờ Xử Lý', 'class' => 'bg-blue-600'],
        'TT002' => ['label' => 'Đang Giao Hàng', 'class' => 'bg-yellow-500'],
        'TT003' => ['label' => 'Đã Giao Hàng', 'class' => 'bg-green-500'],
        'TT004' => ['label' => 'Đã Nhận Hàng', 'class' => 'bg-emerald-600'],
        'TT005' => ['label' => 'Đã Hủy', 'class' => 'bg-red-600'],
        'TT006' => ['label' => 'Trả Hàng', 'class' => 'bg-red-700'],
        'TT007' => ['label' => 'Giao Chậm', 'class' => 'bg-orange-500'],
    ];
    return $configs[$code] ?? ['label' => 'Không xác định', 'class' => 'bg-gray-500'];
}

// Ảnh random
$placeholderImages = [
    "https://intriphat.com/wp-content/uploads/2023/03/hop-carton-dong-hang-3.jpg",
    "https://cafefcdn.com/203337114487263232/2024/10/26/464385008102238323746298706642100005426166399n-1729884014454670501745-1729884387387-17298843877621930862296-1729924046888-1729924047068427834891.jpg",
    "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPk6yitzvHNEhbC1WIJWiW6XowOBgHxBNHGA&s",
    "https://get.pxhere.com/photo/box-carton-odyssey-product-design-packaging-and-labeling-package-delivery-221916.jpg",
    "https://hopcartondonghang.com/wp-content/uploads/2023/08/thung-carton-dung-sau-rieng-14.jpg"
];
function randomImage($imgs) {
    return $imgs[array_rand($imgs)];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách đơn hàng</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col items-center p-8">

  <h1 class="text-3xl font-bold text-blue-700 mb-8">Danh sách đơn hàng (Demo)</h1>

  <section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 w-full max-w-6xl">
    <?php foreach($orders as $o): 
      $status = getStatusConfig($o['TT_Ma']); ?>
      <article class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-2xl">
        <div class="h-40 bg-gray-100">
          <img src="<?= randomImage($placeholderImages) ?>" alt="Ảnh đơn <?= $o['DH_Ma'] ?>" class="w-full h-full object-cover">
        </div>
        <div class="p-5 flex flex-col gap-3">
          <h2 class="text-lg font-semibold text-gray-800">Mã đơn: <?= $o['DH_Ma'] ?></h2>
          <p class="text-sm text-gray-600">Ghi chú: <?= htmlspecialchars($o['DH_GhiChu']) ?></p>

          <!-- Button trạng thái -->
          <button disabled class="px-3 py-2 text-white text-sm font-semibold rounded-lg shadow <?= $status['class'] ?>">
            <?= $status['label'] ?>
          </button>

          <!-- Link theo dõi -->
          <a href="/map/customer_map.php?order_id=<?= urlencode($o['DH_Ma']) ?>" 
             class="text-blue-600 hover:underline text-sm mt-2">
             Theo dõi đơn →
          </a>
        </div>
      </article>
    <?php endforeach; ?>
  </section>

</body>
</html>
