<?php
session_start();
require 'db_connect.php'; // Koneksi database

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil username dari database
$query = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

// Proses form checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $shipping = trim($_POST['shipping']);
    $payment = trim($_POST['payment']);
    $cart = json_decode($_POST['cart'], true);

    // Validasi apakah keranjang tidak kosong
    if (empty($cart)) {
        echo "<script>alert('Keranjang kosong!'); window.location.href='index.php';</script>";
        exit();
    }

    // Ambil product_id dari item pertama di cart
    $product_id = $cart[0]['id'];

    // Simpan data checkout ke sesi
    $_SESSION['checkout_data'] = [
        'product_id' => $product_id, // Tambahkan product_id ke sini
        'address' => $address,
        'phone' => $phone,
        'shipping' => $shipping,
        'payment' => $payment,
        'cart' => $cart
    ];

    // Redirect ke confirmation.php
    header("Location: confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styleindex.css">
    <title>Checkout</title>
</head>
<body>
    <header class="bg-primary text-white text-center py-4">
        <h1>Checkout</h1>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Glamora</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="baju.php">Baju</a></li>
                    <li class="nav-item"><a class="nav-link" href="sepatu.php">Sepatu</a></li>
                    <li class="nav-item"><a class="nav-link" href="tas.php">Tas</a></li>
                    <li class="nav-item"><a class="nav-link" href="semuaproduk.php">Semua Produk</a></li>
                    <li class="nav-item"><button class="btn btn-danger" onclick="logout()">Logout</button></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulir detail pemesanan -->
    <section class="container my-4">
        <h2 class="mb-4">Produk di Keranjang</h2>
        <div id="cartItems"></div>
        <form id="checkoutForm" method="POST">
            <h2 class="mb-4">Detail Pengiriman</h2>
            <div class="mb-3">
                <label for="name" class="form-label">Nama:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat:</label>
                <textarea id="address" name="address" class="form-control" placeholder="Masukkan alamat lengkap" required></textarea>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon:</label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Masukkan nomor telepon" pattern="[0-9]{10,15}" required>
                <small class="form-text text-muted">Gunakan format: 08XXXXXXXX</small>
            </div>

            <h2 class="mt-4">Pilih Metode Pengiriman</h2>
            <div class="form-check">
                <input type="radio" name="shipping" value="Reguler" class="form-check-input" id="shippingReguler" checked>
                <label class="form-check-label" for="shippingReguler">Reguler</label>
            </div>
            <div class="form-check">
                <input type="radio" name="shipping" value="Ekspres" class="form-check-input" id="shippingEkspres">
                <label class="form-check-label" for="shippingEkspres">Ekspres</label>
            </div>

            <h2 class="mt-4">Pilih Metode Pembayaran</h2>
            <div class="form-check">
                <input type="radio" name="payment" value="Transfer Bank" class="form-check-input" id="paymentBank" checked>
                <label class="form-check-label" for="paymentBank">Transfer Bank</label>
            </div>
            <div class="form-check">
                <input type="radio" name="payment" value="E-Wallet" class="form-check-input" id="paymentEWallet">
                <label class="form-check-label" for="paymentEWallet">E-Wallet</label>
            </div>
            <div class="form-check">
                <input type="radio" name="payment" value="Kartu Kredit" class="form-check-input" id="paymentKartuKredit">
                <label class="form-check-label" for="paymentKartuKredit">Kartu Kredit</label>
            </div>

            <input type="hidden" name="cart" id="cart" value="">
            <button type="submit" class="btn btn-success mt-4" id="submitBtn">Konfirmasi Pesanan</button>
        </form>
    </section>

    <footer class="text-center py-4">
        <p>&copy; 2024 Glamora. All rights reserved.</p>
    </footer>

    <script>
        // Fungsi untuk menampilkan produk di keranjang
        function displayCartItems() {
            const cartItemsContainer = document.getElementById('cartItems');
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '<p>Keranjang masih kosong.</p>';
            } else {
                let itemsHtml = '<ul class="list-group">';
                cart.forEach(item => {
                    itemsHtml += `<li class="list-group-item">${item.name} - ${item.quantity} pcs</li>`;
                });
                itemsHtml += '</ul>';
                cartItemsContainer.innerHTML = itemsHtml;
            }
        }

        // Panggil fungsi untuk menampilkan produk di keranjang saat halaman dimuat
        displayCartItems();

        // Simpan cart ke hidden input
        document.getElementById('cart').value = localStorage.getItem('cart');

        // Fungsi untuk logout
        function logout() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                window.location.href = "login.html";
            }
        }
    </script>
</body>
</html>
