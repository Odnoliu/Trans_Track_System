<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xác thực OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-background {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
        }
    </style>    
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="flex flex-col items-center justify-center max-w-4xl w-full bg-white rounded-2xl shadow-lg overflow-hidden border border-blue-500 p-8 md:p-12">
        
        <h2 class="text-3xl font-bold text-blue-800 mb-2">Xác thực OTP</h2>
        <p class="text-gray-600 mb-8 text-center">
            Một mã xác thực đã được gửi đến email và số điện thoại của bạn. Vui lòng kiểm tra hộp thư và nhập mã vào ô bên dưới.
        </p>
        
        <form method="POST" action="/index.php" class="w-full max-w-sm">
            <input type="hidden" name="action" value="verify_otp">
            <input type="hidden" name="username" value="<?php echo $_SESSION['temp_username'] ?? ''; ?>">
            
            <div class="mb-6">
                <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">Mã OTP</label>
                <input type="text" id="otp" name="otp" class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-center text-lg tracking-widest font-mono" placeholder="******" required>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition-colors duration-200">
                Xác thực
            </button>
            
            <?php if (isset($error)) {
                echo "<p class='text-red-500 text-sm mt-2 text-center'>$error</p>";
            } ?>
        </form>
    </div>

</body>
</html>