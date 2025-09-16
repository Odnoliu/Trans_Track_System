<?php
    $error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-blue-500">LogiX</h1>
    <img src="../images/favicon.png" alt="" class="w-16 h-16 max-w-full max-h-full">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <form method="POST" action="../index.php">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên đăng nhập" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Đăng nhập</button>
            <?php if (isset($error)) echo "<p class='text-red-500 mt-2'>$error</p>"; ?>
        </form>
    </div>
</body>
</html>

