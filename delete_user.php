<?php
// Koneksi ke database
include 'db_connect.php'; // Ganti dengan file koneksi database Anda

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Query untuk menghapus pengguna
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId); // i untuk integer

    if ($stmt->execute()) {
        echo "<script>alert('Pengguna berhasil dihapus!'); window.location.href='manajemen-pengguna.php';</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $stmt->error . "'); window.location.href='manajemen-pengguna.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
