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

// Ambil user_id dari session
$userId = $_SESSION['user_id'];

$productName = $_POST['productName'];
$productCategory = $_POST['productCategory'];
$productPrice = $_POST['productPrice'];
$productStock = $_POST['productStock'];

//Buat direktori file 
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (getimagesize($_FILES["file"]["tmp_name"]) === false) {
    die("File bukan gambar.");
}

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $productImage = basename($_FILES["file"]["name"]);
    $sql = "INSERT INTO produk (name, category, price, stock, file, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdisi", $productName, $productCategory, $productPrice, $productStock, $productImage, $userId);

    if ($stmt->execute()) {
        echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='manajemen-produk.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Terjadi kesalahan saat mengunggah gambar.";
}

$stmt->close();
$conn->close();
?>
