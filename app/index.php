<?php
global $koneksi;
$products = mysqli_query($koneksi, "SELECT * FROM produk");

$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Home - Daftar Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-[#121212] text-white font-sans min-h-screen">

  <!-- Header -->
  <header class="bg-[#18181b] px-6 py-4 flex justify-between items-center shadow">
    <div class="flex items-center gap-3">
      <div class="bg-blue-600 rounded-md p-2 text-white text-xl font-bold flex items-center justify-center" style="width: 36px; height: 36px;">
        <span class="font-sans select-none">⌘</span>
      </div>
      <div>
        <p class="text-sm font-semibold">Gorengan</p>
        <p class="text-xs text-gray-400">Gorengan paling enak loh ya😂</p>
      </div>
    </div>
    <button id="toggleCart" class="relative p-2 border border-gray-700 rounded hover:border-gray-500">
      <i class="fas fa-shopping-cart text-white text-lg"></i>

      <?php if (count($cart) > 0): ?>
        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1 rounded-full">
          <?= array_sum(array_column($cart, 'qty')) ?>
        </span>
      <?php endif; ?>
    </button>

  </header>

  <!-- Main Content -->
  <main class="p-6 max-w-7xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Daftar Produk</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <!-- Produk Card -->
       <?php foreach($products as $product) : ?>
        <div class="bg-[#1a1a1a] rounded-lg shadow-md p-4 hover:shadow-lg transition">
            <img src="data:image/png;base64,<?= htmlspecialchars($product['gambar']) ?>" alt="<?= $product['nama_produk'] ?>" loading="lazy" class="w-full h-40 object-cover rounded mb-3">
            <h3 class="text-white text-sm font-semibold"><?= $product['nama_produk'] ?></h3>
            <div class="mt-3 flex justify-between items-center text-sm">
                <span class="text-blue-400 font-semibold">Rp <?= number_format($product['harga'], 0, ',', '.') ?></span>
                <form action="/cart/add" method="POST" class="mt-3">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="bg-blue-600 px-3 py-1 text-sm rounded hover:bg-blue-700">+ Tambah ke Keranjang</button>
                </form>
                <!-- <button class="bg-blue-600 px-3 py-1 rounded hover:bg-blue-700 text-white text-xs">Beli</button> -->
            </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Sidebar Keranjang -->
  <div id="cartSidebar" class="fixed top-0 right-0 w-80 h-full bg-[#1a1a1a] text-white shadow-lg border-l border-gray-700 transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
    <div class="p-4 flex justify-between items-center border-b border-gray-700">
      <h2 class="text-lg font-semibold">Keranjang</h2>
      <button id="closeCart" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
    </div>
    <div class="p-4 space-y-4">
      <?php if (count($cart) === 0): ?>
        <p class="text-gray-400">Keranjang kosong.</p>
      <?php else: 
        $total = 0;
        foreach ($cart as $id => $item):
          $subtotal = $item['qty'] * $item['product']['harga'];
          $total += $subtotal;
      ?>
        <div class="border-b border-gray-700 pb-2">
          <h3 class="text-sm font-semibold mb-1"><?= $item['product']['nama_produk'] ?></h3>

          <div class="flex items-center justify-between mb-1">
            <div class="flex items-center gap-2">
              <!-- Tombol Kurang -->
              <form action="/cart/decrease" method="POST" class="inline">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="submit" class="px-2 py-1 text-sm bg-gray-700 rounded hover:bg-gray-600">−</button>
              </form>

              <!-- Jumlah -->
              <span class="text-gray-300 text-sm"><?= $item['qty'] ?></span>

              <!-- Tombol Tambah -->
              <form action="/cart/increase" method="POST" class="inline">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="submit" class="px-2 py-1 text-sm bg-gray-700 rounded hover:bg-gray-600">+</button>
              </form>
            </div>

            <!-- Harga -->
            <span class="text-blue-400 text-sm">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
          </div>

          <div class="flex justify-end">
            <a href="/cart/remove?id=<?= $id ?>" class="text-red-400 text-xs hover:underline">Hapus</a>
          </div>
        </div>
      <?php endforeach; ?>
        <div class="pt-4 border-t border-gray-700">
          <p class="text-sm font-bold">Total: Rp <?= number_format($total, 0, ',', '.') ?></p>
          <button id="openCheckoutModal" class="mt-3 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded text-sm">Checkout</button>
        </div>
      <?php endif; ?>
    </div>
  </div>


  <!-- Modal Checkout -->
  <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden px-4">
    <div class="bg-[#1a1a1a] rounded-lg shadow-lg w-full max-w-md border border-gray-700 p-6 relative">
      <button id="closeCheckoutModal" class="absolute top-2 right-3 text-gray-400 hover:text-white text-lg">&times;</button>
      <h2 class="text-xl font-semibold mb-4">Isi Data Pembeli</h2>
      <form action="/cart/checkout" method="POST" class="space-y-4">
        <div>
          <label class="block text-sm mb-1 text-gray-300">Nama</label>
          <input type="text" name="nama" class="w-full p-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>
        <div>
          <label class="block text-sm mb-1 text-gray-300">Alamat</label>
          <input type="text" name="alamat" class="w-full p-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-sm">Bayar</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById("toggleCart");
    const closeBtn = document.getElementById("closeCart");
    const cart = document.getElementById("cartSidebar");

    toggleBtn.addEventListener("click", () => {
      cart.classList.toggle("translate-x-full");
    });

    closeBtn.addEventListener("click", () => {
      cart.classList.add("translate-x-full");
    });

    const openCheckoutBtn = document.getElementById('openCheckoutModal');
    const closeCheckoutBtn = document.getElementById('closeCheckoutModal');
    const checkoutModal = document.getElementById('checkoutModal');

    openCheckoutBtn?.addEventListener('click', () => {
      checkoutModal.classList.remove('hidden');
    });

    closeCheckoutBtn?.addEventListener('click', () => {
      checkoutModal.classList.add('hidden');
    });

    // Optional: klik di luar modal untuk menutup
    checkoutModal?.addEventListener('click', (e) => {
      if (e.target === checkoutModal) {
        checkoutModal.classList.add('hidden');
      }
    });
  </script>

</body>
</html>
