<?php
header("Content-Type: application/json; charset=UTF-8");

require_once("../config/connect_databases.php");
require_once("../controller/orders_controller.php");

try {
    $orderController = new OrderController($pdo);
    $orders = $orderController->getAllOrders();

    echo json_encode([
        "status" => "success",
        "data" => $orders
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}