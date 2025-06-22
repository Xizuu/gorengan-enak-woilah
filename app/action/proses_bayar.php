<?php
header('Content-Type: application/json');

global $koneksi;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$items = $input["cart"] ?? [];

function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $randomString;
}

foreach ($items as $item) {
    $order_id = generateRandomString();
    $id = $item["id"];
    $qty = $item["qty"];
    $total = $qty * $item["price"];

    $stmt = mysqli_prepare($koneksi, "INSERT INTO riwayat (id, id_produk, total_harga, kuantitas) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["error" => "Prepare failed: " . mysqli_error($koneksi)]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "siii", $order_id, $id, $total, $qty);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_errno($stmt)) {
        http_response_code(500);
        echo json_encode(["error" => mysqli_stmt_error($stmt)]);
        exit;
    }
}

echo json_encode(["success" => true]);
exit;
