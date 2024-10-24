<?php
session_start();
require 'db_connect.php'; // Menghubungkan ke database

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mendapatkan produk_id$produk_id dari URL
$produk_id = $_GET['id'] ?? null;

if ($produk_id) {
    // Query untuk mengambil detail produk
    $stmt = $conn->prepare("SELECT name, category, price, stock, file, description FROM produk WHERE id = ?");
    $stmt->bind_param("i", $produk_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $category, $price, $stock, $file, $description);

    // Jika produk ditemukan
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
    } else {
        echo "<p>Produk tidak ditemukan saat ini.</p>";
        exit;
    }

    $stmt->close();
} else {
    echo "<p>Product ID tidak ditemukan.</p>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="glamoras.jpg" type="image/jpeg">
  <title>Detail Produk - Toko Online</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styleindex.css">
  <link rel="stylesheet" href="detail-produk.css">
</head>
<body>
  <header class="bg-light text-center py-3">
    <h1>Detail Produk</h1>
  </header>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Glamora</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="baju.php">Baju</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sepatu.php">Sepatu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="tas.php">Tas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="semuaproduk.php">Semua Produk</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="container my-5" id="productDetail">
  <div class="row">
    <div class="col-md-6">
    <img src="<?php echo 'uploads/' . htmlspecialchars($file); ?>" alt="<?php echo htmlspecialchars($name); ?>" class="img-fluid">
    </div>
    <div class="col-md-6">
      <h2><?php echo htmlspecialchars($name); ?></h2>
      <p>Kategori: <?php echo htmlspecialchars($category); ?></p>
      <p>Harga: Rp <?php echo number_format($price, 0, ',', '.'); ?></p>
      <p>Stok: <?php echo htmlspecialchars($stock); ?> tersedia</p>
      <p>Deskripsi: <?php echo htmlspecialchars($description); ?></p>
      <a href="semuaproduk.php" class="btn btn-primary">Kembali ke Semua Produk</a>
      <button class="btn btn-success" onclick="addToCart('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">Tambah ke Keranjang</button>
    </div>
  </div>
</section>


  <section class="comments-section">
    <h3>Komentar</h3>
    <div class="comments-list" id="commentsList">
      <!-- Komentar akan ditampilkan di sini -->
    </div>
    <form id="commentForm" class="comment-form">
      <textarea id="commentInput" rows="3" placeholder="Tulis komentar kamu..." required></textarea>
      <button type="submit" class="submit-btn">Kirim</button>
    </form>
  </section>
  
  <footer class="bg-light text-center py-3">
    <p>&copy; 2024 Glamora. All rights reserved.</p>
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
  <!-- <script src="detail-produk.js"></script> -->
</body>
</html>
