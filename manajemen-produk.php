<!DOCTYPE html> <!-- manajemen-produk.php -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
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

    <div class="main-content">
        <h4>Manajemen Produk</h4>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Tambah Produk</button>
        <div class="card">
            <div class="card-header">
                <h5>Daftar Produk</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            include 'db_connect.php';
                            $sql = "SELECT * FROM produk";
                            $result = $conn->query($sql);

                            if ($result === false) {
                                echo "Error: " . $conn->error;
                            } elseif ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$row['name']}</td>
                                        <td>{$row['category']}</td>
                                        <td>Rp {$row['price']}</td>
                                        <td>{$row['stock']}</td>
                                        <td><img src='uploads/{$row['file']}' alt='{$row['name']}' style='width: 100px;'></td>
                                        <td>
                                            <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editProductModal' 
                                                data-id='{$row['id']}'
                                                data-name='" . htmlspecialchars($row['name']) . "' 
                                                data-category='" . htmlspecialchars($row['category']) . "' 
                                                data-price='" . htmlspecialchars($row['price']) . "' 
                                                data-stock='" . htmlspecialchars($row['stock']) . "'>
                                                Edit
                                            </button>
                                            <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteProductModal' 
                                                data-id='{$row['id']}' data-name='" . htmlspecialchars($row['name']) . "'>
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Tidak ada produk ditemukan.</td></tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="upload-product.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="productName" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" name="productCategory" id="">
                                <option value="sepatu">Sepatu</option>
                                <option value="baju">Baju</option>
                                <option value="tas">Tas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="productPrice" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="productStock" required>
                        </div>
                        <div class="form-group">
                            <label>Gambar Produk</label>
                            <input type="file" class="form-control-file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="update-product.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="productId" id="productId">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="productName" id="productName" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" name="productCategory" id="productCategory">
                                <option value="sepatu">Sepatu</option>
                                <option value="baju">Baju</option>
                                <option value="tas">Tas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="productPrice" id="productPrice" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="productStock" id="productStock" required>
                        </div>
                        <div class="form-group">
                            <label>Gambar Produk</label>
                            <input type="file" class="form-control-file" name="file">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Perbarui Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Produk -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Konfirmasi Hapus Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus produk <strong id="productName"></strong>?
                </div>
                <div class="modal-footer">
                    <form id="deleteProductForm" action="delete-product.php" method="POST">
                        <input type="hidden" name="productId" id="productId">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editProductModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var category = button.data('category');
            var price = button.data('price');
            var stock = button.data('stock');

            var modal = $(this);
            modal.find('#productId').val(id);
            modal.find('#productName').val(name);
            modal.find('#productCategory').val(category);
            modal.find('#productPrice').val(price);
            modal.find('#productStock').val(stock);
        });

        $('#deleteProductModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');

        var modal = $(this);
        modal.find('#productId').val(id);
        modal.find('#productName').text(name);
        });

    </script>
</body>
</html>
