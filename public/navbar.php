<?php
    session_start();

    // Nếu chưa đăng nhập thì quay lại login
    if (!isset($_SESSION['role'])) {
        header("Location: /auth/login.php");
        exit;
    }

    $role = $_SESSION['role'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Xác định avatar và mô tả
    $avatar = "";
    $description = "";

    switch ($role) {
        case 'VT001': // Admin
            $avatar = "../../images/admin.png";
            $description = "Quản trị viên";
            break;
        case 'VT003': // Customer
            $avatar = "../../images/customer-service.png";
            $description = "Khách hàng";
            break;
        case 'VT004': // Provider
            $avatar = "../../images/augmented-reality.png";
            $description = "Nhà cung cấp";
            break;
        case 'VT002': // Employee
            if ($user_id == 2) {
                $avatar = "../../images/delivery.png";
                $description = "Nhân viên giao hàng (Xe máy)";
            } elseif ($user_id == 3) {
                $avatar = "../../images/delivery-man.png";
                $description = "Nhân viên giao hàng (Xe tải)";
            } 
            break;
    }

?>

<script src="https://cdn.tailwindcss.com"></script>

<nav class="bg-blue-600 p-4 shadow-md w-full flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center space-x-3">
        <img src="/images/logo.jpg" alt="Logo" class="w-12 h-12 rounded-full border-2 border-white shadow-md">
        <span class="text-white text-2xl font-bold">LogiX</span>
    </div>

    <!-- Menu -->
    <ul class="flex space-x-6 text-white font-medium">
        <?php if ($role == 'VT001'): // Admin ?>
            <li><a href="/admin/admin.php" class="hover:text-yellow-300">Thống kê đơn hàng</a></li>
            <li><a href="/admin/manage_accounts.php" class="hover:text-yellow-300">Thống kê doanh thu</a></li>
            <li><a href="/admin/manage_order.php" class="hover:text-yellow-300">Thống kê trả hàng</a></li>
        <?php elseif ($role == 'VT003'): // Customer ?>
            <li><a href="/customer/customer.php" class="hover:text-green-300">Đơn hàng của bạn</a></li>
            <li><a href="/customer/confirm.php" class="hover:text-green-300">Xác nhận nhận hàng</a></li>
            <li><a href="/customer/oder_history.php" class="hover:text-green-300">Lịch sử đơn hàng</a></li>

        <?php elseif ($role == 'VT004'): // Provider ?>
            <li><a href="/provider/manage_shipping.php" class="hover:text-blue-300">Theo dõi đơn</a></li>

        <?php elseif ($role == 'VT002'): // Employee ?>
            <li><a href="/delivery_employee/employee.php" class="hover:text-purple-300">Danh sách đơn hàng</a></li>
            <li><a href="/delivery_employee/process_orders.php" class="hover:text-purple-300">Lịch sử đã giao</a></li>
            <li><a href="/delivery_employee/confirm_delivery.php" class="hover:text-purple-300">Xác nhận giao hàng</a></li>
        <?php endif; ?>
    </ul>

    <!-- Avatar + Mô tả + Logout -->
    <div class="flex items-center space-x-4">
        <!-- Avatar -->
        <img src="<?php echo $avatar; ?>" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
        
        <!-- Mô tả -->
        <span class="text-white font-semibold"><?php echo $description; ?></span>

        <!-- Logout -->
        <a href="/logout.php" class="text-red-300 hover:text-red-500 font-medium">Đăng xuất</a>
    </div>
</nav>

