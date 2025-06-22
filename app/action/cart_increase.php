<?php

$id = $_POST['product_id'] ?? null;

if ($id && isset($_SESSION['cart'][$id])) {
  $_SESSION['cart'][$id]['qty']++;
}

header("Location: /");
exit;
