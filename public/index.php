<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LogiX - Đơn hàng</title>
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Icon -->
  <script src="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/tabler-icons.min.js"></script>
  <!-- Animate.css CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    /* Tuỳ chỉnh hiệu ứng nổi lên định kỳ */
    @keyframes floatUp {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }
    .float-animate {
      animation: floatUp 3s ease-in-out infinite;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen flex flex-col items-center py-10">

  <!-- Logo / Tên hệ thống -->
  <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-green-500 
             animate__animated animate__fadeInDown animate__slow mb-6">
    LogiX
  </h1>
  <p class="text-lg text-gray-600 mb-10 animate__animated animate__fadeIn animate__delay-1s">
    Hệ thống vận chuyển & theo dõi đơn hàng thông minh
  </p>

  <!-- Danh sách đơn hàng -->
  <h2 class="text-3xl font-bold text-blue-700 mb-8 animate__animated animate__fadeInUp">Danh sách đơn hàng</h2>

  <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 w-11/12 max-w-6xl">
    <?php
      // Demo dữ liệu giả định
      $orders = [
        [
          "id" => 1,
          "name" => "Laptop Dell XPS 13",
          "image" => "images/orders/order1.jpg",
        ],
        [
          "id" => 2,
          "name" => "Màn hình Samsung 27\"",
          "image" => "images/orders/order2.jpg",
        ],
        [
          "id" => 3,
          "name" => "Chuột Logitech MX Master 3",
          "image" => "images/orders/order3.jpg",
        ]
      ];

      $delay = 0;
      foreach ($orders as $order) {
        $delay += 1; // tăng delay để các card vào lần lượt
        echo "
        <div class='bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl 
                    animate__animated animate__fadeInUp animate__delay-{$delay}s float-animate'>
          <img src='{$order['image']}' alt='{$order['name']}' class='h-48 w-full object-cover'>
          <div class='p-5'>
            <h2 class='text-xl font-semibold text-gray-800 mb-2'>{$order['name']}</h2>
            <p class='text-gray-600 mb-4'>Mã đơn: #{$order['id']}</p>
            <a href='map.php?order_id={$order['id']}' 
               class='inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg transition'>
              <i class='ti ti-eye mr-2'></i> Xem tiến độ
            </a>
          </div>
        </div>";
      }
    ?>
  </div>

</body>
</html>
