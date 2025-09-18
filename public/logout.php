<?php
    require __DIR__ . '/config/connect_databases.php';
    require __DIR__ . '/controller/auth_controller.php'; 
    $authController = new AuthController($pdo);
    $authController->logout();