<?php
// Giả định dữ liệu số lượng đơn hàng năm 2025
// Đơn vị: số đơn
include("../navbar.php");
$donhang2025 = [
    "Tháng 1" => ["customer" => 120, "locker" => 80],
    "Tháng 2" => ["customer" => 150, "locker" => 95],
    "Tháng 3" => ["customer" => 160, "locker" => 100],
    "Tháng 4" => ["customer" => 180, "locker" => 110],
    "Tháng 5" => ["customer" => 200, "locker" => 130],
    "Tháng 6" => ["customer" => 220, "locker" => 140],
    "Tháng 7" => ["customer" => 210, "locker" => 150],
    "Tháng 8" => ["customer" => 230, "locker" => 160],
    "Tháng 9" => ["customer" => 250, "locker" => 170],
    "Tháng 10" => ["customer" => 270, "locker" => 190],
    "Tháng 11" => ["customer" => 300, "locker" => 200],
    "Tháng 12" => ["customer" => 320, "locker" => 220],
];

// Xuất dữ liệu sang JSON cho Chart.js
$labels = json_encode(array_keys($donhang2025), JSON_UNESCAPED_UNICODE);
$customerOrders = json_encode(array_column($donhang2025, 'customer'));
$lockerOrders = json_encode(array_column($donhang2025, 'locker'));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>So sánh đơn hàng 2025</title>
  <!-- TailwindCSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen flex flex-col items-center justify-center p-6">

  <!-- Header -->
  <h1 class="text-3xl md:text-4xl font-bold text-emerald-700 mb-6 animate-bounce">
    So sánh số lượng đơn hàng năm 2025
  </h1>

  <!-- Container Card -->
  <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-6 transition transform hover:scale-105 hover:shadow-2xl duration-500">
    <canvas id="ordersChart" class="w-full h-96"></canvas>
  </div>

  <!-- Footer -->
  <p class="mt-6 text-gray-600 text-sm">
    © 2025 Hệ thống Logistics - Thống kê vận chuyển
  </p>

  <script>
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?php echo $labels; ?>,
        datasets: [
          {
            label: 'Giao tại địa điểm khách hàng',
            data: <?php echo $customerOrders; ?>,
            borderColor: 'rgba(16, 185, 129, 1)',
            backgroundColor: 'rgba(16, 185, 129, 0.2)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
          },
          {
            label: 'Giao tại Smart Locker',
            data: <?php echo $lockerOrders; ?>,
            borderColor: 'rgba(59, 130, 246, 1)',
            backgroundColor: 'rgba(59, 130, 246, 0.2)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          title: {
            display: true,
            text: 'So sánh số lượng đơn hàng theo tháng năm 2025',
            color: '#065f46',
            font: { size: 18, weight: 'bold' }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { color: '#374151' }
          },
          x: {
            ticks: { color: '#374151' }
          }
        }
      }
    });
  </script>
</body>
</html>
