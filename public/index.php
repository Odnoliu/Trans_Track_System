<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trans Track System</title>
    <link href="css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-blue-600 mb-4 text-center">Chào mừng đến với Trans Track System!</h1>
        <p class="text-gray-600 mb-4 text-center">Hệ thống theo dõi vận chuyển sử dụng PHP và TailwindCSS.</p>
        <?php
            $message = "Hello from PHP! Ngày hiện tại: " . date('Y-m-d');
            echo "<p class='text-green-500 text-center font-semibold'>$message</p>";
        ?>
        <button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
            Theo dõi lô hàng
        </button>
    </div>
    <script src="js/script.js"></script>
</body>
</html>