<?php
// Giả định dữ liệu doanh thu năm 2025 (tỷ VNĐ) cho hệ thống logistics
include("../navbar.php");
$doanhthu2025 = [
    "Tháng 1" => 15,
    "Tháng 2" => 18,
    "Tháng 3" => 20,
    "Tháng 4" => 25,
    "Tháng 5" => 30,
    "Tháng 6" => 35,
    "Tháng 7" => 33,
    "Tháng 8" => 38,
    "Tháng 9" => 42,
    "Tháng 10" => 48,
    "Tháng 11" => 52,
    "Tháng 12" => 60
];

$labels = json_encode(array_keys($doanhthu2025), JSON_UNESCAPED_UNICODE);
$values = json_encode(array_values($doanhthu2025));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thống kê Doanh thu 2025</title>
  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex flex-col items-center justify-center p-6">

  <!-- Header -->
  <h1 class="text-3xl md:text-4xl font-bold text-indigo-700 mb-6 animate-pulse">
    Biểu đồ doanh thu logistics năm 2025
  </h1>

  <!-- Container Card -->
  <div class="w-full max-w-4xl bg-white shadow-xl rounded-2xl p-6 transition transform hover:scale-105 hover:shadow-2xl duration-500">
    <canvas id="revenueChart" class="w-full h-96"></canvas>
  </div>

  <!-- Footer -->
  <p class="mt-6 text-gray-600 text-sm">
    © 2025 Hệ thống Logistics - Demo thống kê
  </p>

  <script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
      type: 'bar', // có thể đổi thành 'line'
      data: {
        labels: <?php echo $labels; ?>,
        datasets: [{
          label: 'Doanh thu (tỷ VNĐ)',
          data: <?php echo $values; ?>,
          backgroundColor: [
            'rgba(99, 102, 241, 0.6)',
            'rgba(16, 185, 129, 0.6)',
            'rgba(239, 68, 68, 0.6)',
            'rgba(234, 179, 8, 0.6)',
            'rgba(59, 130, 246, 0.6)',
            'rgba(236, 72, 153, 0.6)',
            'rgba(132, 204, 22, 0.6)',
            'rgba(249, 115, 22, 0.6)',
            'rgba(14, 165, 233, 0.6)',
            'rgba(168, 85, 247, 0.6)',
            'rgba(245, 158, 11, 0.6)',
            'rgba(34, 197, 94, 0.6)',
          ],
          borderColor: 'rgba(55, 65, 81, 1)',
          borderWidth: 1,
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { 
            position: 'top',
            labels: { color: '#374151', font: { size: 14 } }
          },
          title: {
            display: true,
            text: 'Thống kê doanh thu theo tháng năm 2025',
            color: '#1e3a8a',
            font: { size: 18, weight: 'bold' }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { color: '#1f2937' }
          },
          x: {
            ticks: { color: '#1f2937' }
          }
        }
      }
    });
  </script>
</body>
</html>
