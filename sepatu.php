<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="glamoras.jpg" type="image/jpeg">
  <title>Sepatu - Toko Online</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styleindex.css">
  <style>
    .card:hover {
      transform: scale(1.05);
      transition: 0.3s ease;
    }
    .progress-bar {
      background-color: #28a745;
    }
  </style>
</head>
<body>

  <!-- Jumbotron for Header -->
  <header class="jumbotron text-center bg-warning text-dark">
    <h1 class="display-4">Kategori Sepatu</h1>
    <p class="lead">Koleksi sepatu stylish untuk berbagai aktivitas dan gaya.</p>
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
  <section class="container my-5">
      <div class="row">
          <?php
          include 'db_connect.php'; // Pastikan file ini benar dan terhubung dengan database
          $sql = "SELECT * FROM produk WHERE category = 'sepatu'"; // Menampilkan hanya produk dengan kategori sepatu
          $result = $conn->query($sql);

          if ($result === false) {
              echo "Error: " . $conn->error;
          } elseif ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  // Menampilkan setiap produk sepatu
                  echo '<div class="col-md-4 mb-4">';
                  echo '  <div class="card h-100 shadow-sm">';
                  echo '      <img src="uploads/' . htmlspecialchars($row['file']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                  echo '      <div class="card-body text-center">';
                  echo '          <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                  echo '          <p class="card-text">Rp ' . number_format($row['price'], 0, ',', '.') . ' ';
                  // Tambahkan badge jika produk adalah best seller atau baru
                  if ($row['is_best_seller']) {
                      echo '<span class="badge badge-danger">Best Seller!</span>';
                  } elseif ($row['is_new']) {
                      echo '<span class="badge badge-warning">Baru!</span>';
                  } elseif ($row['discount']) {
                      echo '<span class="badge badge-info">Diskon ' . $row['discount'] . '%</span>';
                  }
                  echo '</p>';
                  echo '          <a href="detail-produk.html?produk=' . urlencode($row['name']) . '&price=' . urlencode('Rp ' . number_format($row['price'], 0, ',', '.')) . '&image=' . urlencode($row['file']) . '" class="btn btn-primary">Lihat Detail</a>';
                  echo '      </div>';
                  echo '      <div class="card-footer">';
                  echo '          <div class="progress">';
                  echo '              <div class="progress-bar" role="progressbar" style="width: ' . $row['stock'] . '%;" aria-valuenow="' . $row['stock'] . '" aria-valuemin="0" aria-valuemax="100">Stok ' . $row['stock'] . '%</div>';
                  echo '          </div>';
                  echo '      </div>';
                  echo '  </div>';
                  echo '</div>';
              }
          } else {
              echo '<p>Tidak ada produk sepatu yang ditemukan.</p>';
          }
          ?>
      </div>
  </section>



  <footer class="bg-warning text-dark text-center py-4">
    <p>&copy; 2024 Glamora. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JS dan dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
