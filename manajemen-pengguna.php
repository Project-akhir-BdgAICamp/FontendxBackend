<?php
session_start();
require 'db_connect.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo "Anda tidak memiliki izin untuk mengedit data pengguna.";
    exit();
}

// Tampilkan daftar pengguna
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Hitung jumlah pengguna
$totalUsers = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f8f9fa; }
        .sidebar { height: 100vh; width: 250px; position: fixed; top: 0; left: 0; background-color: #343a40; padding-top: 20px; }
        .sidebar a { color: #cfd8dc; display: block; padding: 15px; text-decoration: none; }
        .sidebar a:hover { background-color: #495057; color: #ffffff; }
        .main-content { margin-left: 250px; padding: 20px; }
        .card-header { background-color: #343a40; color: white; }
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
        <a href="laporan.php"><i class="bi bi-graph-up"></i> Laporan Penjualan</a>
        <a href="setting.html"><i class="bi bi-gear"></i> Pengaturan Website</a>
        <a href="#logout" onclick="logout()"><i class="bi bi-box-arrow-right"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h4>Manajemen Pengguna</h4>
        <button class="btn btn-custom mb-3" data-toggle="modal" data-target="#addUserModal"><i class="bi bi-plus"></i> Tambah Pengguna</button>

        <!-- Filter Pengguna -->
        <div class="mb-3">
            <label for="filterRole" class="form-label">Filter Role:</label>
            <select class="form-control" id="filterRole">
                <option value="all">Semua</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

    <!-- Untuk list pengguna -->
        <div class="card">
            <div class="card-header">
                <h5>Daftar Pengguna (Total: <?= $totalUsers ?>)</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['level']); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal" 
                                            data-username="<?= htmlspecialchars($row['username']); ?>" 
                                            data-email="<?= htmlspecialchars($row['email']); ?>" 
                                            data-level="<?= htmlspecialchars($row['level']); ?>">
                                        Edit
                                    </button>
                                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Tidak ada pengguna ditemukan</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="create-user.php" method="POST">
                        <div class="form-group">
                            <label for="userName">Nama Pengguna</label>
                            <input type="text" class="form-control" name="username" id="userName" placeholder="Masukkan nama pengguna" required>
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" class="form-control" name="email" id="userEmail" placeholder="Masukkan email" required>
                        </div>
                        <div class="form-group">
                            <label for="userRole">Level</label>
                            <select class="form-control" name="level" id="level" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editUserStatus">Password</label>
                            <input class="form-control" name="password" id="editUserStatus" placeholder="masukkan password user" required>
                        </div>
                        <!-- <div class="form-group">
                            <label for="userStatus">Status</label>
                            <select class="form-control" name="status" id="userStatus" required>
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div> -->
                        <input type="hidden" name="action" value="add">
                        <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="update-user.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="current_email" value="">
                            <div class="form-group">
                                <label for="editUserName">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="editUserEmail">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="editUserLevel">Level</label>
                                <select class="form-control" name="level" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editUserPassword">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Masukkan password baru (kosongkan jika tidak ingin diubah)">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var username = button.data('username');
            var email = button.data('email');
            var level = button.data('level');

            var modal = $(this);
            modal.find('input[name="username"]').val(username);
            modal.find('input[name="email"]').val(email);
            modal.find('select[name="level"]').val(level);
            modal.find('input[name="current_email"]').val(email);
        });
    </script>
</body>
</html>
