<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="glamoras.jpg" type="image/jpeg">
  <title>Semua Produk - Toko Online</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styleindex.css">
  <style>
    .card:hover {
      transform: scale(1.05);
      transition: 0.3s ease;
    }
  </style>
</head>
<body>

  <!-- Jumbotron for Header -->
  <header class="jumbotron text-center bg-info text-white">
    <h1 class="display-4">Semua Produk</h1>
    <p class="lead">Temukan semua produk kami di sini.</p>
  </header>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

  <!-- Products Section -->
  <!-- Products Section -->
  <section class="container my-5">
      <div class="row">
          <?php
          include 'db_connect.php';
          $sql = "SELECT * FROM produk";
          $result = $conn->query($sql);

          if ($result === false) {
              echo "Error: " . $conn->error;
          } elseif ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  // Pastikan stok tidak lebih dari 100% atau kurang dari 0%
                  $stokPersentase = min(max(($row['stock'] / 100) * 100, 0), 100); // Sesuaikan dengan jumlah stok sebenarnya
                  
                  echo "<div class='col-md-4 mb-4'>
                          <div class='card h-100 shadow-sm'>
                              <img src='uploads/" . htmlspecialchars($row['file']) . "' class='card-img-top' alt='" . htmlspecialchars($row['name']) . "'>
                              <div class='card-body text-center'>
                                  <h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>
                                  <p class='card-text'>Rp " . number_format($row['price'], 0, ',', '.') . "</p>";

                  // Menampilkan badge jika produk ada diskon atau status tertentu
                  if (isset($row['status']) && $row['status'] == 'diskon') {
                      echo " <span class='badge badge-success'>Diskon</span>";
                  } elseif (isset($row['status']) && $row['status'] == 'baru') {
                      echo " <span class='badge badge-warning'>Baru!</span>";
                  } elseif (isset($row['status']) && $row['status'] == 'best-seller') {
                      echo " <span class='badge badge-danger'>Best Seller!</span>";
                  }

                  echo "</p>
                                  <a href='detail-produk.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary'>Lihat Detail</a>
                              </div>
                              <div class='card-footer'>
                                  <div class='progress'>
                                      <div class='progress-bar' role='progressbar' style='width: {$stokPersentase}%;' aria-valuenow='{$stokPersentase}' aria-valuemin='0' aria-valuemax='100'>Stok {$stokPersentase}%</div>
                                  </div>
                              </div>
                          </div>
                      </div>";
              }
          } else {
              echo "<p class='text-center'>Tidak ada produk yang tersedia.</p>";
          }

          $conn->close();
          ?>
      </div>
  </section>




  <footer class="bg-info text-white text-center py-4">
    <p>&copy; 2024 Glamora. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JS dan dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="semuaproduk.js"></script>
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
</body>
</html>
