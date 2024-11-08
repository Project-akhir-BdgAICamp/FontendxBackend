<?php
session_start();
require 'db_connect.php'; // Pastikan file ini ada dan koneksi database berhasil

// Aktifkan error reporting untuk menampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil username dari database
$query = "SELECT id FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($id);
$stmt->fetch();
$conn->close();

// Simulasi penyimpanan data checkout (ini seharusnya terjadi di halaman lain sebelum akses form)
if (!isset($_SESSION['checkout_data'])) {
    $_SESSION['checkout_data'] = [
        'product_id' => '5' // Simulasi product_id
    ];
}

// Ambil product_id dari sesi
if (isset($_SESSION['checkout_data'])) {
    $checkout_data = $_SESSION['checkout_data'];

    // Cek apakah product_id ada
    if (isset($checkout_data['product_id'])) {
        $product_id = htmlspecialchars($checkout_data['product_id'], ENT_QUOTES, 'UTF-8'); // Sanitasi output
    } else {
        $product_id = ''; // Set ke string kosong jika product_id tidak ada
    }
} else {
    $product_id = ''; // Set ke string kosong jika data tidak tersedia
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styleindex.css">
    <title>Review Produk</title>
    <style>
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }

        .submit-btn {
            background-color: #0077b6; /* Warna tombol */
            color: white;
            padding: 10px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #005f8c; /* Warna saat hover */
        }

        /* Style untuk bintang rating */
        .rating {
            display: flex;
            direction: row-reverse;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .rating input {
            display: none;
        }

        .rating label {
            cursor: pointer;
            font-size: 2rem;
            color: #ccc;
        }

        .rating input:checked ~ label {
            color: #ffc107;
        }

        .rating label:hover,
        .rating label:hover ~ label {
            color: #ffc107;
        }
    </style>
</head>

<body>
    <header class="bg-primary text-white text-center py-4">
        <h1>Review Produk</h1>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="baju.php">Baju</a></li>
                    <li class="nav-item"><a class="nav-link" href="sepatu.php">Sepatu</a></li>
                    <li class="nav-item"><a class="nav-link" href="tas.php">Tas</a></li>
                    <li class="nav-item"><a class="nav-link" href="semuaproduk.php">Semua Produk</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="container my-4">
        <h2 class="text-center">Berikan Ulasan Anda</h2>
        <form id="reviewForm" action="submit-review.php" method="POST">
            <div class="mb-3">
                <label for="orderNumber" class="form-label">user id : </label>
                <input type="text" id="orderNumber" name="user_id" class="form-control" value="<?php echo htmlspecialchars($id); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="product" class="form-label">Produk yang Diulas:</label>
                <input type="text" id="product" name="product_id" class="form-select" value="<?php echo $product_id; ?>" readonly></select>
            </div>
            <div class="mb-3">
                <label class="form-label">Rating:</label>
                <div class="rating">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5" title="5 stars">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4" title="4 stars">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3" title="3 stars">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2" title="2 stars">&#9733;</label>
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1" title="1 star">&#9733;</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="review" class="form-label">Ulasan Anda:</label>
                <textarea id="review" name="review_text" class="form-control" rows="5" placeholder="Tulis ulasan Anda di sini..." required></textarea>
            </div>
            <button type="submit" class="submit-btn" >Kirim Ulasan</button>
        </form>        
    </section>

    <!-- <footer class="text-center">
        <p>&copy; 2024 Glamora. All rights reserved.</p>
    </footer> -->

    <script>
        function loadPurchasedProducts() {
            const purchasedProducts = JSON.parse(localStorage.getItem('purchasedProducts')) || [];
            const productSelect = document.getElementById('product');
            productSelect.innerHTML = '';

            if (purchasedProducts.length === 0) {
                productSelect.innerHTML = '<option>Tidak ada produk yang dibeli</option>';
            } else {
                purchasedProducts.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.title;
                    option.text = item.title;
                    productSelect.add(option);
                });
            }
        }

        window.onload = loadPurchasedProducts;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
