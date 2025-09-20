<?php
header("Content-Type: application/json; charset=UTF-8");

require_once("../config/connect_databases.php");

try {
    // Lấy dữ liệu từ body (JSON)
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['DH_Ma']) || !isset($input['delivery_time']) || !isset($input['delivery_place'])) {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Thiếu tham số DH_Ma, delivery_time hoặc delivery_place",
            "data" => $input
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $DH_Ma = $input['DH_Ma'];
    $delivery_time = trim($input['delivery_time']);
    $delivery_place = trim($input['delivery_place']);
    $TT_Ma = $input['TT_Ma'];
    // Gộp thành ghi chú
    $ghiChu = $delivery_time . " - " . $delivery_place;

    // Cập nhật vào database
    $sql = "UPDATE DonHang SET DH_GhiChu = :ghiChu, TT_Ma = :tt_ma WHERE DH_Ma = :DH_Ma";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":ghiChu", $ghiChu);
    $stmt->bindParam(":tt_ma", $TT_Ma);
    $stmt->bindParam(":DH_Ma", $DH_Ma);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Cập nhật ghi chú thành công",
            "data" => [
                "DH_Ma" => $DH_Ma,
                "DH_GhiChu" => $ghiChu
            ]
        ], JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("Không thể cập nhật ghi chú cho đơn hàng");
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
