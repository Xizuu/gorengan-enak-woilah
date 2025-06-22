<?php
require_once "./core/session.php";

if (!is_logged_in()) {
  redirect("/login");
  exit;
}

$id = $_GET['id'] ?? null;

if (isset($_SESSION['cart'][$id])) {
  unset($_SESSION['cart'][$id]);
}

header('Location: /');
exit;
