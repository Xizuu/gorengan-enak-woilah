<?php

$id = $_POST['product_id'] ?? null;

if ($id && isset($_SESSION['cart'][$id])) {
  if ($_SESSION['cart'][$id]['qty'] > 1) {
    $_SESSION['cart'][$id]['qty']--;
  } else {
    unset($_SESSION['cart'][$id]);
  }
}

header("Location: /");
exit;
