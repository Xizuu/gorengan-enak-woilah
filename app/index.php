<?php

global $koneksi;
$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$query = "SELECT * FROM produk LIMIT $start, $limit";
$result = $koneksi->query($query);
$total_result = $koneksi->query("SELECT COUNT(*) as total FROM produk")->fetch_assoc()['total'];
$total_pages = ceil($total_result / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicious Foods - Jualan Makanan Enak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 500px;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .category-card {
            transition: all 0.3s ease;
        }
        .category-card:hover {
            transform: scale(1.05);
        }
        .testimonial-card {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="fixed right-0 top-0 w-80 h-full bg-white shadow-lg z-50 transform translate-x-full transition-transform duration-300">
        <div class="flex items-center justify-between px-4 py-4 border-b">
            <h2 class="text-lg font-semibold">Keranjang Saya</h2>
            <button onclick="toggleCart()" class="text-gray-500 hover:text-red-500 text-xl">
                &times;
            </button>
        </div>
        <div id="cartItems" class="p-4 space-y-4">
            <p class="text-gray-500 text-sm text-center">Keranjang masih kosong</p>
        </div>
        <div class="px-4 py-4 border-t">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-700 font-medium">Total:</span>
                <span id="cartTotal" class="text-lg font-bold text-orange-500">Rp 0</span>
            </div>
            <button onclick="handleCheckout()" class="bg-orange-500 w-full text-white py-2 rounded-lg hover:bg-orange-600">Checkout</button>
        </div>
    </div>

    <!-- Overlay -->
    <div id="cartOverlay" onclick="toggleCart()" class="fixed inset-0 bg-black bg-opacity-40 z-40 hidden"></div>

    <!-- Header/Navbar -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="flex items-center">
                <i class="fas fa-utensils text-3xl text-orange-500 mr-2"></i>
                <span class="text-xl font-bold text-gray-800">Delicious<span class="text-orange-500">Foods</span></span>
            </a>
            <div class="flex items-center space-x-4">
                <button onclick="toggleCart()" class="relative text-gray-700 hover:text-orange-500">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span id="cartCount" class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero flex items-center justify-center text-white">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Makanan Enak, Harga Terjangkau</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Temukan berbagai pilihan makanan lezat dengan kualitas terbaik dan harga bersahabat</p>
            <!-- <a href="#" class="bg-orange-500 text-white px-8 py-3 rounded-full font-medium hover:bg-orange-600 transition inline-block">Belanja Sekarang</a> -->
        </div>
    </section>

    <!-- Category Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Kategori Produk</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Tersedia berbagai kategori makanan yang sangat cocok untukmu</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="category-card bg-white p-6 rounded-xl shadow-sm text-center cursor-pointer">
                    <div class="bg-orange-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-hamburger text-3xl text-orange-500"></i>
                    </div>
                    <h3 class="font-semibold text-lg">Makanan Cepat Saji</h3>
                </div>
                <div class="category-card bg-white p-6 rounded-xl shadow-sm text-center cursor-pointer">
                    <div class="bg-green-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-apple-alt text-3xl text-green-500"></i>
                    </div>
                    <h3 class="font-semibold text-lg">Buah-buahan</h3>
                </div>
                <div class="category-card bg-white p-6 rounded-xl shadow-sm text-center cursor-pointer">
                    <div class="bg-blue-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-wine-bottle text-3xl text-blue-500"></i>
                    </div>
                    <h3 class="font-semibold text-lg">Minuman</h3>
                </div>
                <div class="category-card bg-white p-6 rounded-xl shadow-sm text-center cursor-pointer">
                    <div class="bg-purple-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-birthday-cake text-3xl text-purple-500"></i>
                    </div>
                    <h3 class="font-semibold text-lg">Kue & Dessert</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Produk Populer</h2>
                    <p class="text-gray-600">Makanan terbaik pilihan pelanggan kami</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="product-card bg-white rounded-xl overflow-hidden shadow-md transition duration-300">
                        <div class="relative overflow-hidden h-56">
                            <img src="data:image/png;base64,<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-semibold mb-1"><?= htmlspecialchars($row['nama_produk']) ?></h3>
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-orange-500 font-bold text-lg">Rp <?= number_format($row['harga'], 0, ',', '.') ?></span>
                                <button onclick="addToCart(<?= $row['id'] ?>, '<?= addslashes($row['nama_produk']) ?>', <?= $row['harga'] ?>)" class="bg-orange-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-orange-600">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="mt-10 flex justify-center space-x-2">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="px-4 py-2 rounded-lg border <?= ($i == $page) ? 'bg-orange-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>

        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Apa Kata Pelanggan Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Testimoni dari pelanggan yang puas dengan produk kami</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="testimonial-card bg-white p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Pelanggan" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-semibold">Sarah Wijaya</h4>
                            <div class="flex text-yellow-400 text-sm"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Burger premiumnya benar-benar enak dan worth it untuk harganya. Pelayanan juga cepat dan packing rapi. Akan order lagi!"</p>
                </div>
                <div class="testimonial-card bg-white p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Pelanggan" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-semibold">Budi Santoso</h4>
                            <div class="flex text-yellow-400 text-sm"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Pizza-nya lezat banget, kejunya melimpah. Cocok buat acara keluarga. Pengiriman juga cepat!"</p>
                </div>
                <div class="testimonial-card bg-white p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Pelanggan" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-semibold">Nina Lestari</h4>
                            <div class="flex text-yellow-400 text-sm"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Saya suka saladnya, segar dan sehat! Cocok buat yang diet. Packingnya rapi dan higienis."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">DeliciousFoods</h4>
                    <p class="text-gray-400 text-sm">Temukan makanan lezat berkualitas dengan harga terjangkau. Kami siap memenuhi kebutuhan kuliner Anda setiap saat!</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <ul class="text-gray-400 text-sm space-y-2">
                        <li><i class="fas fa-phone mr-2"></i> +62 812 3456 7890</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@deliciousfoods.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Yogyakarta, Indonesia</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4 text-lg">
                        <a href="#" class="hover:text-orange-500"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-orange-500"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-orange-500"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-orange-500"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center text-gray-500 text-sm mt-10">
                &copy; 2025 DeliciousFoods. Semua Hak Dilindungi.
            </div>
        </div>
    </footer>
    <script>
        let cart = [];

        function toggleCart() {
            document.getElementById('cartSidebar').classList.toggle('translate-x-full');
            document.getElementById('cartOverlay').classList.toggle('hidden');
        }

        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
        }

        function loadCart() {
            const stored = localStorage.getItem('cart');
            if (stored) {
                cart = JSON.parse(stored);
            } else {
                cart = [];
            }
            updateCartUI();
        }

        function addToCart(id, name, price) {
            const index = cart.findIndex(item => item.id === id);
            if (index !== -1) {
                cart[index].qty++;
            } else {
                cart.push({ id, name, price, qty: 1 });
            }
            saveCart();
        }


        function removeFromCart(index) {
            cart.splice(index, 1);
            saveCart();
        }

        function increaseQty(index) {
            cart[index].qty++;
            saveCart();
        }

        function decreaseQty(index) {
            cart[index].qty--;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
            saveCart();
        }

        function updateCartUI() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const cartTotal = document.getElementById('cartTotal');
            cartItems.innerHTML = '';

            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-gray-500 text-sm text-center">Keranjang masih kosong</p>';
                cartTotal.textContent = 'Rp 0';
            } else {
                let totalHargaSemua = 0;

                cart.forEach((item, index) => {
                    const totalHarga = item.qty * item.price;
                    totalHargaSemua += totalHarga;

                    const div = document.createElement('div');
                    div.className = 'flex justify-between items-center gap-4 border-b pb-3 mb-3';
                    div.innerHTML = `
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800">${item.name}</h4>
                            <p class="text-sm text-gray-500">Rp ${totalHarga.toLocaleString()}</p>
                            <div class="flex items-center mt-2 space-x-2">
                                <button onclick="decreaseQty(${index})" class="w-7 h-7 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">-</button>
                                <span class="text-gray-700 font-medium">${item.qty}</span>
                                <button onclick="increaseQty(${index})" class="w-7 h-7 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">+</button>
                            </div>
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700 text-xl">&times;</button>
                    `;
                    cartItems.appendChild(div);
                });

                cartTotal.textContent = `Rp ${totalHargaSemua.toLocaleString()}`;
            }

            const totalQty = cart.reduce((acc, item) => acc + item.qty, 0);
            cartCount.textContent = totalQty;
        }

        window.onload = loadCart;
    </script>

    <script>
    async function handleCheckout() {
        if (cart.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Keranjang kosong',
                text: 'Silakan tambahkan produk terlebih dahulu.',
            });
            return;
        }

        const confirmed = await Swal.fire({
            title: 'Lanjutkan Checkout?',
            text: 'Pastikan pesanan Anda sudah benar.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Checkout',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#6b7280'
        });

        if (confirmed.isConfirmed) {
            // Tampilkan loading SweetAlert
            Swal.fire({
                title: 'Memproses pesanan...',
                html: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('/cart/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ cart }),
                });

                Swal.close(); // Tutup loading setelah respon diterima

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Checkout Berhasil!',
                        text: 'Pesanan Anda telah diproses.',
                        confirmButtonColor: '#f97316'
                    }).then(() => {
                        localStorage.removeItem('cart');
                        cart = [];
                        updateCartUI();
                        window.location.href = '/'; // Opsional redirect
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Checkout Gagal!',
                        text: 'Terjadi kesalahan saat memproses pesanan.',
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.close(); // Pastikan tetap ditutup jika error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tidak dapat terhubung ke server.',
                });
            }
        }
    }
</script>



</body>
</html>
