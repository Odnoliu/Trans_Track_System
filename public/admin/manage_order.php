<?php
// Giả định dữ liệu số lượng đơn hàng trả hàng trong năm 2025
// (giả sử đơn vị: số đơn hàng)
include("../navbar.php");

$return2025 = [
    "Tháng 1" => 12,
    "Tháng 2" => 15,
    "Tháng 3" => 9,
    "Tháng 4" => 18,
    "Tháng 5" => 22,
    "Tháng 6" => 17,
    "Tháng 7" => 25,
    "Tháng 8" => 28,
    "Tháng 9" => 30,
    "Tháng 10" => 20,
    "Tháng 11" => 26,
    "Tháng 12" => 35
];

$labels = json_encode(array_keys($return2025), JSON_UNESCAPED_UNICODE);
$values = json_encode(array_values($return2025));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thống kê Trả hàng 2025</title>
  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-100 min-h-screen flex flex-col items-center justify-center p-6">

  <!-- Header -->
  <h1 class=" mt-10 text-3xl md:text-4xl font-bold text-red-700 mb-6 animate-bounce">
    Biểu đồ thống kê đơn hàng trả lại năm 2025
  </h1>

  <!-- Container Card -->
  <div class="w-full max-w-4xl bg-white shadow-xl rounded-2xl p-6 transition transform hover:scale-105 hover:shadow-2xl duration-500">
    <canvas id="returnChart" class="w-full h-96"></canvas>
  </div>

  <!-- Footer -->
  <p class="mt-6 text-gray-600 text-sm">
    © 2025 Hệ thống Logistics - Demo thống kê trả hàng
  </p>

  <script>
    const ctx = document.getElementById('returnChart').getContext('2d');
    const returnChart = new Chart(ctx, {
      type: 'line', // đổi sang 'bar' nếu muốn dạng cột
      data: {
        labels: <?php echo $labels; ?>,
        datasets: [{
          label: 'Số đơn trả hàng',
          data: <?php echo $values; ?>,
          backgroundColor: 'rgba(239, 68, 68, 0.4)',
          borderColor: 'rgba(239, 68, 68, 1)',
          borderWidth: 2,
          fill: true,
          tension: 0.3,
          pointBackgroundColor: 'rgba(220, 38, 38, 1)',
          pointRadius: 5,
          pointHoverRadius: 7
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
            text: 'Thống kê số đơn hàng bị trả lại theo tháng - 2025',
            color: '#991b1b',
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
