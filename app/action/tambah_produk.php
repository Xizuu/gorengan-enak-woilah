<?php
require_once "./core/session.php";

global $koneksi;
// if (!is_logged_in()) {
//     redirect("/login");
//     exit;
// }

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $produk = $_POST["nama_produk"] ?? '';
    $harga = $_POST["harga"] ?? 0;

    $gambar = "";

    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES["gambar"]["tmp_name"];
        $imageData = file_get_contents($tmpName);

        if ($imageData !== false) {
            $encodedImage = base64_encode($imageData);
            $thumbnail = $encodedImage;
        } else {
            echo "<script>alert('Kesalahan pada gambar')</script>";
            echo "<script>window.location.href = '/produk/add'</script>";
        }
    }


    if ($produk && $harga && !$error) {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO produk (nama_produk, harga, gambar) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sis", $produk, $harga, $thumbnail);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Berhasil menambahkan produk')</script>";
            echo "<script>window.location.href = '/produk'</script>";
        } else {
            echo "<script>alert('Produk gagal ditambahkan')</script>";
            echo "<script>window.location.href = '/produk/add'</script>";
        }
    }

}
?>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <link rel="stylesheet" href="<?= ASSETS ?>/css/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-[#121212] text-white font-sans min-h-screen flex overflow-x-hidden">
  <!-- Sidebar -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-56 p-4 bg-[#18181b] flex flex-col justify-between transform -translate-x-full sm:translate-x-0 transition-transform duration-300 ease-in-out">
    <div>
      <a href="#" class="flex items-center gap-3 mb-8">
        <div class="bg-blue-600 rounded-md p-2 text-white text-xl font-bold flex items-center justify-center" style="width: 36px; height: 36px;">
          <span class="font-sans select-none">⌘</span>
        </div>
        <div class="leading-tight">
          <p class="text-sm font-semibold">Laravel Shadcn</p>
          <p class="text-xs text-gray-400">Laravel Inertia Starter</p>
        </div>
      </a>
      <nav class="flex flex-col gap-4 text-sm">
        <a href="/dashboard" class="flex items-center gap-3 text-gray-300 hover:text-white">
          <i class="fas fa-th-large text-base w-5"></i>
          Dashboard
        </a>
        <a href="/produk" class="flex items-center gap-3 text-gray-300 hover:text-white">
          <i class="fas fa-user-friends text-base w-5"></i>
          Daftar Produk
        </a>
        <a href="/riwayat" class="flex items-center gap-3 text-gray-300 hover:text-white">
          <i class="fas fa-cog text-base w-5"></i>
          Riwayat Penjualan
        </a>
      </nav>
    </div>
    <!-- Container -->
    <div class="relative text-xs text-gray-400" id="userMenu">
      <div class="flex items-center gap-3 cursor-pointer" id="userToggle">
        <div class="bg-blue-900 rounded-md w-6 h-6 flex items-center justify-center font-semibold select-none">CR</div>
        <div class="leading-tight">
          <p class="text-white font-semibold text-[10px]">Carlos RGL</p>
          <p class="text-[9px]">contact@carlosrgl.com</p>
        </div>
        <button aria-label="More options" class="ml-auto text-gray-400 hover:text-white">
          <i class="fas fa-chevron-down text-xs"></i>
        </button>
      </div>

      <!-- Dropdown ke atas -->
      <div id="dropdownMenu" class="absolute right-0 bottom-full mb-2 w-36 bg-[#1f1f1f] rounded shadow-lg border border-gray-700 hidden z-50">
        <button class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700">
          <i class="fa-solid fa-right-from-bracket"></i>
          Logout
        </button>
      </div>
    </div>
  </aside>

  <!-- Overlay for mobile when sidebar is open -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden sm:hidden"></div>

  <!-- Main content -->
  <div class="flex-1 flex flex-col p-6 space-y-6 ml-0 sm:ml-56 w-full">
    <!-- Top bar -->
    <header class="flex items-center justify-between border-b border-gray-800 pb-3">
      <div class="flex items-center gap-3 text-gray-300 text-sm">
        <!-- Burger button for mobile -->
        <button id="burgerBtn" aria-label="Toggle sidebar" class="sm:hidden p-2 mr-2 rounded border border-gray-700 hover:border-gray-500">
          <i class="fas fa-bars text-gray-300"></i>
        </button>
        <!-- <i class="far fa-window-maximize text-lg"></i> -->
        <span>Dashboard</span>
      </div>
      <button aria-label="Toggle dark mode" class="p-2 rounded border border-gray-700 hover:border-gray-500">
        <i class="fas fa-moon text-gray-300"></i>
      </button>
    </header>

    <section class="bg-[#18181b] shadow-lg rounded-xl p-6 flex flex-col flex-1 max-w-full" style="min-width: 0">
        <div class="mb-4">
            <h2 class="text-white font-semibold text-base">Tambah Produk</h2>
        </div>

        <form action="/produk/add" method="POST" enctype="multipart/form-data" class="space-y-4 max-w-xl">
            <!-- Nama Produk -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-300 mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" required
                    class="w-full px-4 py-2 bg-[#121212] border border-gray-700 text-white rounded-md focus:outline-none focus:ring focus:border-blue-500 text-sm" />
            </div>

            <!-- Harga Produk -->
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-300 mb-1">Harga (Rp)</label>
                <input type="text" inputmode="numeric" name="harga" required
                    class="w-full px-4 py-2 bg-[#121212] border border-gray-700 text-white rounded-md focus:outline-none focus:ring focus:border-blue-500 text-sm" />
            </div>

            <!-- Upload Gambar -->
            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-300 mb-1">Gambar Produk</label>
                <input type="file" name="gambar"
                    class="w-full bg-[#121212] border border-gray-700 text-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700" />
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-2">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-semibold transition">
                    Kirim
                </button>
                <a type="button"
                    href="/produk"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md text-sm font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </section>

  </div>

  <script src="<?= ASSETS ?>/js/script.js"></script>
</body>
</html>