<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xác thực OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <form method="POST" action="/index.php">
            <input type="hidden" name="action" value="verify_otp">
            <input type="hidden" name="username" value="<?php echo $_SESSION['temp_username'] ?? ''; ?>">
            <label for="otp" class="block text-sm font-medium text-gray-700">Mã OTP</label>
            <input type="text" id="otp" name="otp" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Nhập mã OTP" required>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md mt-4">Xác thực</button>
            <?php if (isset($error)) echo "<p class='text-red-500 mt-2'>$error</p>"; ?>
        </form>
    </div>
</body>
</html>