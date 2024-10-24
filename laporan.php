<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
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
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h5 class="text-center text-light">Admin Panel</h5>
        <a href="admin-dashboard.html"><i class="bi bi-speedometer2"></i> Dashboard Admin</a>
        <a href="#products" data-toggle="collapse" data-target="#productsMenu"><i class="bi bi-grid-fill"></i> Manajemen</a>
        <div id="productsMenu" class="collapse submenu">
            <a href="manajemen-produk.php"><i class="bi bi-box-seam"></i> Manajemen Produk</a>
            <a href="manajemen-pengguna.php"><i class="bi bi-people"></i> Manajemen Pengguna</a>
            <a href="manajemen-ulasan.html"><i class="bi bi-chat-dots"></i> Manajemen Ulasan & Komentar</a>
        </div>
        <a href="laporan.html"><i class="bi bi-graph-up"></i> Laporan Penjualan</a>
        <a href="setting.html"><i class="bi bi-gear"></i> Pengaturan Website</a>
        <a href="#logout" onclick="logout()"><i class="bi bi-box-arrow-right"></i> Log Out</a>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <h4>Laporan Penjualan</h4>
        <!-- Total Penjualan -->
        <div class="card mb-3">
            <div class="card-header">
                <h5>Total Penjualan</h5>
            </div>
            <div class="card-body">
                <h3>Rp. 15.000.000</h3>
                <p>Jumlah penjualan bulan ini.</p>
            </div>
        </div>
        <!-- Tabel Laporan Penjualan -->
        <div class="card mb-3">
            <div class="card-header">
                <h5>Rincian Checkout</h5>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Produk ID</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Metode Pengiriman</th>
                            <th>Metode Pembayaran</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Koneksi ke Database
                        $conn = new mysqli("localhost", "root", "", "db_toko");

                        // Cek koneksi
                        if ($conn->connect_error) {
                            die("Koneksi gagal: " . $conn->connect_error);
                        }

                        // Ambil data dari tabel checkout
                        $sql = "SELECT * FROM checkout";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Tampilkan data setiap baris
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["user_id"] . "</td>";
                                echo "<td>" . $row["product_id"] . "</td>";
                                echo "<td>" . $row["alamat"] . "</td>";
                                echo "<td>" . $row["telephone"] . "</td>";
                                echo "<td>" . $row["metode_pengiriman"] . "</td>";
                                echo "<td>" . $row["metode_pembayaran"] . "</td>";
                                echo "<td><a href='download.php?file=" . urlencode($row['file']) . "'>Download File</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada data checkout</td></tr>";
                        }

                        // Tutup koneksi
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Grafik Penjualan Bulanan -->
        <div class="card">
            <div class="card-header">
                <h5>Grafik Penjualan Bulanan</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery, Popper.js, Bootstrap JS, Chart.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function logout() {
            alert('Anda telah keluar dari sistem!');
        }
        // Data untuk grafik penjualan
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Penjualan Bulanan',
                    data: [12000000, 15000000, 9000000, 13000000, 17000000, 20000000, 18000000, 22000000, 24000000, 30000000, 25000000, 32000000],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
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
