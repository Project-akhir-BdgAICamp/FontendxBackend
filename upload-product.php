<?php

// Tampilkan semua error (untuk debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php'; // Koneksi ke database

$productName = $_POST['productName'];
$productCategory = $_POST['productCategory'];
$productDescription = $_POST['productDescription'];
$productPrice = $_POST['productPrice'];
$productStock = $_POST['productStock'];

// Mengatur direktori tempat menyimpan gambar
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Cek apakah file gambar atau bukan
$check = getimagesize($_FILES["file"]["tmp_name"]);
if ($check === false) {
    die("File bukan gambar.");
}

// Pindahkan file ke folder 'uploads'
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $productImage = basename($_FILES["file"]["name"]);

    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO produk (name, category, description, price, stock, file)
            VALUES ('$productName', '$productCategory', '$productDescription', '$productPrice', '$productStock', '$productImage')";

    if ($conn->query($sql) === TRUE) {
        echo "Produk berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Terjadi kesalahan saat mengunggah gambar.";
}

// Tutup koneksi
$conn->close();
?>