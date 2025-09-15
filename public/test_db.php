<?php
    // File này để ae test kết nối với CSDL. Chỉnh tên hoặc đường dẫn tới file connect_databases.php
    // và sửa các biến để test nhé
    require __DIR__ . '/../config/connect_databases.php';
    echo "Kết nối thành công đến CSDL: " . $dbname;
    // Test query đơn giản
    $stmt = $pdo->query("SHOW TABLES;");
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<br>Số bảng hiện có: " . count($tables);
?>