<?php

global $koneksi;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE username = ?");
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  if ($user && md5($password) === $user["password"]) {
    $_SESSION['username'] = $user['username'];
    echo "<script>alert('Berhasil login!')</script>";
    echo "<script>window.location.href = '/dashboard'</script>";
    exit;
  } else {
    $error = 'Username atau password salah.';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#080808] min-h-screen flex items-center justify-center">
  <form method="POST" class="bg-transparent border border-gray-800 rounded-md p-6 w-80" autocomplete="off" spellcheck="false" aria-label="Login form">
    <h2 class="text-white font-semibold text-lg mb-2">Login</h2>
    <p class="text-gray-400 text-sm mb-4">Masukkan username untuk login sebagai ADMIN.</p>
    
    <?php if ($error): ?>
      <div class="text-red-500 text-xs mb-3"><?= $error ?></div>
    <?php endif; ?>

    <label for="username" class="block text-gray-400 text-xs mb-1">Username</label>
    <input
      name="username"
      type="text"
      placeholder="John Doe"
      class="w-full mb-4 rounded-md border border-gray-800 bg-[#080808] text-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600"
      required
    />
    <label for="password" class="text-gray-400 text-xs">Password</label>
    <input
      name="password"
      type="password"
      class="w-full mb-5 rounded-md border border-gray-800 bg-[#080808] text-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-600"
      required
    />
    <button
      type="submit"
      class="w-full bg-white text-black rounded-md py-2 text-sm font-normal hover:bg-gray-200 transition-colors"
    >
      Login
    </button>
  </form>
</body>
</html>
