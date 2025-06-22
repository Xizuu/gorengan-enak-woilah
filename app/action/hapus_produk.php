<?php
require_once "./core/session.php";

global $koneksi;
// if (!is_logged_in()) {
//     redirect("/login");
//     exit;
// }

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}

// Pastikan data dengan ID tersebut ada
$stmt = mysqli_prepare($koneksi, "SELECT id FROM produk WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) === 0) {
    die("Data tidak ditemukan.");
}

// Lakukan penghapusan
$stmt = mysqli_prepare($koneksi, "DELETE FROM produk WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Berhasil menghapus produk')</script>";
    echo "<script>window.location.href = '/produk'</script>";
    exit;
} else {
    die("Gagal menghapus data.");
}
?>