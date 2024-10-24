<?php
// admin_dashboard.php
session_start();
require 'db_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
// if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] != 'admin') {
//     header("Location: admin-dashboard.php");
//     exit();
// }

// Konten khusus admin
echo "Selamat datang di Dashboard Admin!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            transition: transform 0.3s ease;
        }

        .sidebar.closed {
            transform: translateX(-100%);
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

        .sidebar .submenu a {
            padding-left: 30px;
            font-size: 0.9rem;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.shifted {
            margin-left: 0;
        }

        .toggle-btn {
            position: fixed; /* Changed to fixed */
            top: 15px;
            left: 15px;
            z-index: 1000;
            background-color: #343a40;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
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
    <!-- Toggle Button -->
    <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h5 class="text-center text-light">Admin Panel</h5>
        <a href="admin-dashboard.html"><i class="bi bi-speedometer2"></i> Dashboard Admin</a>
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
<div class="main-content" id="mainContent">
    <!-- Dashboard -->
    <div class="card" id="dashboard">
        <div class="card-body">
            <h4>Dashboard Admin</h4>
            <p>Ringkasan pesanan terbaru, produk terlaris, dan analitik penjualan.</p>
            <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Pesanan Terbaru</h5>
                                <p class="card-text">5 Pesanan Terakhir</p>
                                <ul class="list-group">
                                <?php
                                    include 'db_connect.php'; // Pastikan koneksi ke database
                                    error_reporting(E_ALL);
                                    ini_set('display_errors', 1);

                                    // Query untuk mengambil 5 ID terbaru dari tabel checkout
                                    $sql = "SELECT id FROM checkout ORDER BY id DESC LIMIT 5"; // Ambil ID checkout terbaru
                                    $result = $conn->query($sql);

                                    // Cek apakah query berhasil
                                    if ($result === false) {
                                        echo "<li class='list-group-item'>Error: " . $conn->error . "</li>";
                                    } elseif ($result->num_rows > 0) {
                                        // Menampilkan ID checkout terbaru
                                        echo "<ul class='list-group'>";
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<li class='list-group-item'>Pesanan #{$row['id']}</li>";
                                        }
                                        echo "</ul>";
                                    } else {
                                        echo "<li class='list-group-item'>Tidak ada pesanan terbaru.</li>";
                                    }

                                    $conn->close(); // Tutup koneksi
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Produk Terlaris</h5>
                            <p class="card-text">5 Produk Paling Laku</p>
                            <ul class="list-group">
                            <?php
                                include 'db_connect.php'; // Pastikan koneksi ke database
                                error_reporting(E_ALL);
                                ini_set('display_errors', 1);

                                // Query untuk mengambil 5 produk terbaru berdasarkan ID
                                $sql = "SELECT id, name FROM produk ORDER BY id DESC LIMIT 5"; // Ambil produk terbaru
                                $result = $conn->query($sql);

                                // Cek apakah query berhasil
                                if ($result === false) {
                                    echo "<li class='list-group-item'>Error: " . $conn->error . "</li>";
                                } elseif ($result->num_rows > 0) {
                                    // Menampilkan produk terbaru
                                    echo "<ul class='list-group'>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<li class='list-group-item'>Produk #{$row['id']} - {$row['name']}</li>";
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<li class='list-group-item'>Tidak ada produk terbaru.</li>";
                                }

                                $conn->close(); // Tutup koneksi
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>                
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Analitik Penjualan</h5>
                            <canvas id="salesChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('shifted');
        }

        function logout() {
            // Ganti URL dengan rute logout yang sesuai
            window.location.href = 'login.html'; // Atur URL logout sesuai rute Laravel Anda
        }

        const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'],
            datasets: [{
                label: 'Penjualan Bulanan',
                data: [12, 19, 3, 5, 2, 3, 15, 8, 10], // Ganti data dengan data penjualan sebenarnya
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html>
