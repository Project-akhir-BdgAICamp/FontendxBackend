<?php
session_start();
require 'db_connect.php'; // Pastikan file ini ada dan koneksi database berhasil

// Aktifkan error reporting untuk menampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek jika sesi checkout ada
if (!isset($_SESSION['checkout_data'])) {
    header("Location: index.php"); // Redirect ke halaman awal jika tidak ada data
    exit();
}

$checkout_data = $_SESSION['checkout_data'];

// Tambahkan ini untuk memeriksa apakah username sudah disimpan di sesi
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Username tidak ditemukan.'); window.location.href='index.php';</script>";
    exit(); // Tambahkan exit agar tidak melanjutkan jika username tidak ada
}

// Fungsi untuk mengurangi stok produk
function reduceProductStock($product_id, $quantity, $conn) {
    $query = "UPDATE produk SET stock = stock - ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $quantity, $product_id);
    if (!$stmt->execute()) {
        echo "<script>alert('Database error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Proses jika ada upload file untuk pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['payment_proof'])) {
    $payment_proof = $_FILES['payment_proof'];

    // Validasi file upload
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($payment_proof['type'], $allowed_types)) {
        // Pindahkan file ke direktori yang diinginkan
        $upload_dir = 'uploads/';
        // Pastikan direktori upload sudah ada, jika tidak, buat baru
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $upload_file = $upload_dir . basename($payment_proof['name']);

        if (move_uploaded_file($payment_proof['tmp_name'], $upload_file)) {
            // Simpan order ke database
            $query = "INSERT INTO checkout (user_id, product_id, alamat, telephone, metode_pengiriman, metode_pembayaran, file) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iisssss", $_SESSION['user_id'], $checkout_data['product_id'], $checkout_data['address'], $checkout_data['phone'], $checkout_data['shipping'], $checkout_data['payment'], $upload_file);

            if (!$stmt->execute()) {
                echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            } else {
                // Kurangi stok untuk setiap produk di cart
                foreach ($checkout_data['cart'] as $item) {
                    reduceProductStock($item['id'], $item['quantity'], $conn);
                }

                // Hapus data checkout dari sesi
                unset($_SESSION['checkout_data']);

                echo "<script>alert('Pesanan berhasil dibuat!'); window.location.href='thankyou.html';</script>";
                exit();
            }
            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengunggah bukti pembayaran.');</script>";
        }
    } else {
        echo "<script>alert('Format file tidak diperbolehkan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styleindex.css">
    <title>Konfirmasi Pembayaran</title>
    <style>
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-content p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .close-btn {
            background-color: #0077b6;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-btn:hover {
            background-color: #005f8c;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
    </style>
</head>

<body>
    <header class="bg-primary text-white text-center py-4">
        <h1>Konfirmasi Pesanan</h1>
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
                </ul>
            </div>
        </div>
    </nav>

    <section class="container my-4">
        <h2>Detail Pesanan</h2>
        <p>Name: <span id="confirmUsername"><?php echo htmlspecialchars($_SESSION['username']); ?></span></p>
        <p>Alamat: <span id="confirmAddress"><?php echo htmlspecialchars($checkout_data['address']); ?></span></p>
        <p>Nomor Telepon: <span id="confirmPhone"><?php echo htmlspecialchars($checkout_data['phone']); ?></span></p>

        <h2 class="mt-4">Unggah Bukti Pembayaran</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="payment_proof" required>
            <button type="submit" class="btn btn-primary mt-2">Kirim Bukti Pembayaran</button>
        </form>
    </section>

    <footer class="text-center">
        <p>&copy; 2024 Glamora. All rights reserved.</p>
    </footer>

    <script>
        // Pastikan modal ditutup jika ada klik di luar
        window.onclick = function(event) {
            const modal = document.getElementById('paymentModal');
            if (modal && event.target === modal) { // Pastikan modal ada
                closeModal();
            }
        }

        // Cek apakah ada modal dan simpan modal di variabel
        function closeModal() {
            const modal = document.getElementById('paymentModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>
