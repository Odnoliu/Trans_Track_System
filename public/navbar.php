<?php
session_start();

// Nếu chưa đăng nhập thì quay lại login
if (!isset($_SESSION['role'])) {
    header("Location: /auth/login.php");
    exit;
}

$role = $_SESSION['role'];

?>

<script src="https://cdn.tailwindcss.com"></script>

<nav class="bg-blue-500 p-4 shadow-lg w-full">
    <ul class="flex space-x-6 text-white font-medium">
        <?php if ($role === 'VT001'): // Admin ?>
            <li><a href="/admin/admin.php" class="hover:text-yellow-300">Dashboard Admin</a></li>
            <li><a href="/admin/manage_accounts.php" class="hover:text-yellow-300">Quản lý tài khoản</a></li>
            <li><a href="/admin/manage_orders.php" class="hover:text-yellow-300">Quản lý đơn hàng</a></li>

        <?php elseif ($role === 'VT003'): // Customer ?>
            <li><a href="/customer/customer.php" class="hover:text-green-300">Trang chủ khách hàng</a></li>
            <li><a href="/customer/order_history.php" class="hover:text-green-300">Lịch sử đơn hàng</a></li>

        <?php elseif ($role === 'VT004'): // Provider ?>
            <li><a href="/provider/provider.php" class="hover:text-blue-300">Trang chủ nhà cung cấp</a></li>
            <li><a href="/provider/manage_inventory.php" class="hover:text-blue-300">Quản lý kho</a></li>
            <li><a href="/provider/manage_shipping.php" class="hover:text-blue-300">Quản lý vận chuyển</a></li>

        <?php elseif ($role === 'VT002'): // Employee ?>
            <li><a href="/employee/employee.php" class="hover:text-purple-300">Trang chủ nhân viên</a></li>
            <li><a href="/employee/process_orders.php" class="hover:text-purple-300">Xử lý đơn hàng</a></li>
            <li><a href="/employee/support.php" class="hover:text-purple-300">Hỗ trợ khách hàng</a></li>
        <?php endif; ?>

        <!-- Logout chung cho mọi role -->
        <li><a href="/auth/logout.php" class="ml-auto text-red-400 hover:text-red-600">Đăng xuất</a></li>
    </ul>
</nav>
