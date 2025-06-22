<?php
require_once "./core/session.php";
// Inisialisasi cart jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$method = $_POST['method'] ?? '';
$data = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'get':
        echo json_encode($_SESSION['cart']);
        break;

    case 'add':
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $data['name']) {
                $item['qty'] += 1;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = ['name' => $data['name'], 'price' => $data['price'], 'qty' => 1];
        }
        echo json_encode(['success' => true]);
        break;

    case 'remove':
        array_splice($_SESSION['cart'], $data['index'], 1);
        echo json_encode(['success' => true]);
        break;

    case 'increase':
        $_SESSION['cart'][$data['index']]['qty'] += 1;
        echo json_encode(['success' => true]);
        break;

    case 'decrease':
        if ($_SESSION['cart'][$data['index']]['qty'] > 1) {
            $_SESSION['cart'][$data['index']]['qty'] -= 1;
        } else {
            array_splice($_SESSION['cart'], $data['index'], 1);
        }
        echo json_encode(['success' => true]);
        break;
    case 'reset':
        $_SESSION['cart'] = [];
        echo json_encode(['success' => true]);
        break;

}

// global $koneksi;

// $id = $_POST['product_id'] ?? null;
// if ($id) {
//   $stmt = mysqli_prepare($koneksi, "SELECT * FROM produk WHERE id = ?");
//   mysqli_stmt_bind_param($stmt, "i", $id);
//   mysqli_stmt_execute($stmt);
//   $result = mysqli_stmt_get_result($stmt);
//   $product = mysqli_fetch_assoc($result);

//   if ($product) {
//     if (!isset($_SESSION['cart'])) {
//       $_SESSION['cart'] = [];
//     }

//     if (isset($_SESSION['cart'][$id])) {
//       $_SESSION['cart'][$id]['qty'] += 1;
//     } else {
//       $_SESSION['cart'][$id] = [
//         'product' => $product,
//         'qty' => 1
//       ];
//     }
//   }
// }

// header('Location: /');
// exit;