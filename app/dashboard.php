
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
        <i class="far fa-window-maximize text-lg"></i>
        <span>Dashboard</span>
      </div>
      <button aria-label="Toggle dark mode" class="p-2 rounded border border-gray-700 hover:border-gray-500">
        <i class="fas fa-moon text-gray-300"></i>
      </button>
    </header>

    <!-- Cards top row -->
    <section class="grid grid-cols-1 sm:grid-cols-2 gap-6">
  <!-- Card Jumlah Produk -->
      <div class="bg-[#1a1a1a] rounded-lg h-36 p-4 flex flex-col justify-between">
        <h3 class="text-gray-400 text-sm">Jumlah Produk</h3>
        <p class="text-white text-3xl font-bold">12</p>
      </div>

      <!-- Card Jumlah Pendapatan -->
      <div class="bg-[#1a1a1a] rounded-lg h-36 p-4 flex flex-col justify-between">
        <h3 class="text-gray-400 text-sm">Jumlah Pendapatan</h3>
        <p class="text-green-400 text-3xl font-bold">Rp 325.000</p>
      </div>
    </section>
  </div>

  <script src="<?= ASSETS ?>/js/script.js"></script>

</body>
</html>