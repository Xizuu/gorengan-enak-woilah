<?php
require_once "./core/session.php";

global $koneksi;
if (!is_logged_in()) {
  redirect("/login");
  exit;
}

$items = $_SESSION["cart"] ?? [];

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

foreach ($items as $item) {
    $order_id = generateRandomString(8);
    $id = $item["product"]["id"];
    $qty = $item["qty"];
    $total = $item['qty'] * $item['product']['harga'];

    $stmt_item = mysqli_prepare($koneksi, "INSERT INTO riwayat (id, id_produk, total_harga, kuantitas) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt_item, "siii", $order_id, $id, $total, $qty);
    mysqli_stmt_execute($stmt_item);
}

unset($_SESSION["cart"]);

echo "<script>alert('Berhasil melakukan checkout')</script>";
echo "<script>window.location.href = '/'</script>";
exit;