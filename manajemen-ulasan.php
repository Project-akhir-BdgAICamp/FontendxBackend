<?php
session_start();
require 'db_connect.php'; // Pastikan file ini benar untuk koneksi database

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil data dari tabel review
$sql = "SELECT u.username, p.name AS product_name, r.rating, r.review_text 
        FROM review r
        JOIN users u ON r.user_id = u.id
        JOIN produk p ON r.product_id = p.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Ulasan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #cfd8dc;
            display: block;
            padding: 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: #ffffff;
        }
        .submenu a {
            padding-left: 30px;
            font-size: 0.9rem;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card-header {
            background-color: #343a40;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-custom {
            background-color: #6c757d;
            color: white;
        }
        .status-badge.active {
            background-color: #28a745;
            color: white;
        }
        .status-badge.inactive {
            background-color: #dc3545;
            color: white;
        }
        /* Responsif */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h5 class="text-center text-light">Admin Panel</h5>
        <a href="admin-dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard Admin</a>
        <a href="#products" data-toggle="collapse" data-target="#productsMenu"><i class="bi bi-grid-fill"></i> Manajemen</a>
        <div id="productsMenu" class="collapse submenu">
            <a href="manajemen-produk.php"><i class="bi bi-box-seam"></i> Manajemen Produk</a>
            <a href="manajemen-pengguna.php"><i class="bi bi-people"></i> Manajemen Pengguna</a>
            <a href="manajemen-ulasan.php"><i class="bi bi-chat-dots"></i> Manajemen Ulasan & Komentar</a>
        </div>
        <a href="laporan.php"><i class="bi bi-graph-up"></i> Laporan Penjualan</a>
        <a href="setting.html"><i class="bi bi-gear"></i> Pengaturan Website</a>
        <a href="#logout" onclick="logout()"><i class="bi bi-box-arrow-right"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h4>Manajemen Ulasan</h4>
        
        <!-- Tabel Ulasan -->
        <div class="card">
            <div class="card-header">
                <h5>Daftar Ulasan</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Pengguna</th>
                            <th>Produk</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Tampilkan data ulasan dari database
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['username']}</td>
                                        <td>{$row['product_name']}</td>
                                        <td>" . str_repeat('⭐', $row['rating']) . "</td>
                                        <td>{$row['review_text']}</td>
                                        <td>
                                            <button class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i> Edit</button>
                                            <button class='btn btn-danger btn-sm'><i class='bi bi-trash'></i> Hapus</button>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Tidak ada ulasan ditemukan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function logout() {
            alert('Anda telah keluar dari sistem!');
        }
    </script>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
