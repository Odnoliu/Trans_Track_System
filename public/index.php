<?php
    // public/index.php
    require __DIR__ . '/config/connect_databases.php';
    require __DIR__ . '/controller/auth_controller.php'; 

    $authController = new AuthController($pdo);

    // Debug URI
    echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";

    $error = $authController->login();
    if ($error) {
        require __DIR__ . '/auth/login.php';
    }

?>