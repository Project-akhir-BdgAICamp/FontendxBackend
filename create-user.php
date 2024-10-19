<?php
session_start();
// Tampilkan semua error (untuk debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'db_connect.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo "Anda tidak memiliki izin untuk mengupload produk.";
    exit();
}

// Validasi input
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['level']) || empty($_POST['level'])) {
    echo "Semua field harus diisi!";
    exit();
}

// Ambil user_id dari session
$userId = $_SESSION['user_id'];

$username = $_POST['username'];
$email = $_POST['email'];
$level = $_POST['level'];
$password = $_POST['password'];


// Hash password sebelum menyimpannya ke database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


// Buat query untuk menambahkan user baru
$stmt = $conn->prepare("INSERT INTO users (username, email, level, password) VALUES (?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("ssss", $username, $email, $level, $hashedPassword);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location.href='manajemen-pengguna.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Terjadi kesalahan saat mempersiapkan query.";
}

$conn->close();
?>
