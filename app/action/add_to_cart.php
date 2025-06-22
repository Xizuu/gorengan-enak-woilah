<?php
global $koneksi;

$id = $_POST['product_id'] ?? null;
if ($id) {
  // Hindari SQL injection dengan prepared statements
  $stmt = mysqli_prepare($koneksi, "SELECT * FROM produk WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $product = mysqli_fetch_assoc($result); // Ambil data produk sebagai array

  if ($product) {
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id]['qty'] += 1;
    } else {
      $_SESSION['cart'][$id] = [
        'product' => $product,
        'qty' => 1
      ];
    }
  }
}

header('Location: /');
exit;