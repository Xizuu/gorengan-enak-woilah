<?php
include_once "temp_data.php";
// require_once BASE_APP . '/temp_data.php';

$id = $_POST['product_id'] ?? null;

if ($id && isset($products[$id])) {
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty'] += 1;
  } else {
    $_SESSION['cart'][$id] = [
      'product' => $products[$id],
      'qty' => 1
    ];
  }
}

header('Location: /');
exit;
