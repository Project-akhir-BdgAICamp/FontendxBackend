<?php
// Mulai sesi untuk memeriksa login
session_start();
require 'db_connect.php';

// Cek apakah user sudah login, jika tidak, redirect ke login.html
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header('Location: login.html');
    exit();
}

// Ambil data produk dari database dengan filter
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$maxPrice = isset($_GET['price']) ? $_GET['price'] : 1000000;
$size = isset($_GET['size']) ? $_GET['size'] : 'all';

// Membangun query berdasarkan filter
$sql = "SELECT * FROM produk WHERE price <= $maxPrice";

if ($category !== 'all') {
    $sql .= " AND category = '$category'";
}

if ($size !== 'all') {
    $sql .= " AND size = '$size'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Toko Online</title>
    <link rel="stylesheet" href="styleindex.css">
    <link rel="icon" href="glamoras.jpg" type="image/jpeg">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Fungsi untuk toggle (buka/tutup) side menu
        function toggleMenu() {
            const menu = document.getElementById('sideMenu');
            menu.classList.toggle('open');
        }

        function filterProducts() {
            const category = document.getElementById('category').value;
            const price = document.getElementById('price').value;
            const size = document.getElementById('size').value;
            // Menggunakan encodeURIComponent untuk menghindari masalah dengan karakter khusus
            window.location.href = `index.php?category=${encodeURIComponent(category)}&price=${price}&size=${size}`;
        }
    </script>
    <style>
        /* Tambahan CSS untuk side menu */
        .side-menu {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        .side-menu a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }
        .side-menu a:hover {
            color: #f1f1f1;
        }
        .side-menu .close-btn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
        }
        .side-menu.open {
            width: 250px;
        }
    </style>
</head>
<body>
    <!-- Tombol menu -->
    <button class="btn btn-primary m-3" onclick="toggleMenu()">☰ Menu</button>

    <!-- Side menu -->
    <div id="sideMenu" class="side-menu">
        <a href="#" class="close-btn" onclick="toggleMenu()">×</a>
        <a href="profil.html">Profil</a>
        <a href="shopping-cart.php">Keranjang</a>
        <a href="index.php">Home</a>
        <a href="baju.php">Baju</a>
        <a href="sepatu.php">Sepatu</a>
        <a href="tas.php">Tas</a>
        <a href="semuaproduk.php">Semua Produk</a>
        <a href="wishlist.html">Wishlist</a>
    </div>

    <!-- Header dengan background gradient dan logo di atasnya -->
    <header class="text-center bg-primary text-white py-5">
        <img src="glamora.jpg" alt="Logo Glamora" class="logo-header img-fluid my-3">
    </header>

    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="baju.php">Baju</a></li>
                    <li class="nav-item"><a class="nav-link" href="sepatu.php">Sepatu</a></li>
                    <li class="nav-item"><a class="nav-link" href="tas.php">Tas</a></li>
                    <li class="nav-item"><a class="nav-link" href="semuaproduk.php">Semua Produk</a></li>
                </ul>
                <a href="shopping-cart.php" class="btn btn-outline-primary ms-auto">
                    <img src="keranjang.jpg" alt="Keranjang" style="width: 24px; height: 24px;">
                </a>
            </div>
        </div>
    </nav>

    <!-- Carousel Banner Promosi -->
    <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="banner.jpg" class="d-block w-100" alt="Promo 1">
                <div class="carousel-caption d-none d-md-block" style="text-shadow: 2px 2px 4px #000;">
                    <h5>Diskon 50%</h5>
                    <p>Dapatkan Penawaran Terbaik Sekarang!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="banner1.jpg" class="d-block w-100" alt="Promo 2">
                <div class="carousel-caption d-none d-md-block" style="text-shadow: 2px 2px 4px #000;">
                    <h5>Produk Baru!</h5>
                    <p>Cek Koleksi Terbaru Kami.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Section untuk pencarian dan filter produk -->
    <section class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari produk..." aria-label="Cari produk" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">🔍 Cari</button>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Filter Berdasarkan:</h3>
                <div class="row">
                    <div class="col-md-4">
                        <label for="category" class="form-label">Kategori:</label>
                        <select id="category" class="form-select" onchange="filterProducts()">
                            <option value="all">Semua</option>
                            <option value="baju">Baju</option>
                            <option value="sepatu">Sepatu</option>
                            <option value="tas">Tas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="price" class="form-label">Harga:</label>
                        <input type="range" id="price" min="0" max="1000000" value="500000" class="form-range" onchange="filterProducts()">
                        <span>Rp 0 - Rp 1.000.000</span>
                    </div>
                    <div class="col-md-4">
                        <label for="size" class="form-label">Ukuran:</label>
                        <select id="size" class="form-select" onchange="filterProducts()">
                            <option value="all">Semua</option>
                            <option value="s">S</option>
                            <option value="m">M</option>
                            <option value="l">L</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Produk -->
    <section class="container">
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo 'uploads/' . $row['file']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                                <a href="detail_produk.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Lihat Detail</a>
                                <button class="btn btn-success" onclick="addToCart('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">Tambah ke Keranjang</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <h3>Tidak ada produk ditemukan.</h3>
                </div>
            <?php endif; ?>
        </div>
    </section>


    <!-- Footer -->
    <footer class="text-center py-4">
        <p>&copy; 2024 Toko Online. Semua Hak Dilindungi.</p>
    </footer>

    <script>
    // Fungsi untuk menambahkan barang ke keranjang
    function addToCart(id, name, price) {
        const cart = getCartData();
        
        // Cek apakah produk sudah ada di keranjang
        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.quantity += 1; // Jika ada, tambahkan jumlahnya
        } else {
            cart.push({ id, name, price, quantity: 1 }); // Jika tidak ada, tambahkan item baru
        }
        
        // Simpan kembali ke localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
        
        alert(name + " telah ditambahkan ke keranjang!"); // Memberi notifikasi kepada pengguna
        }

        // Fungsi untuk mendapatkan data keranjang dari localStorage
        function getCartData() {
            return JSON.parse(localStorage.getItem('cart')) || [];
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
