<?php
session_start();
require 'db_connect.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo "Anda tidak memiliki izin untuk mengedit data pengguna.";
    exit();
}

// Validasi input saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $level = $_POST['level'];
    $password = $_POST['password'];
    $currentEmail = $_POST['current_email']; // Email yang sedang diedit

    // Cek apakah email sudah digunakan oleh pengguna lain
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ? AND email != ?");
    $checkEmail->bind_param("ss", $email, $currentEmail);
    $checkEmail->execute();
    $emailResult = $checkEmail->get_result();

    if ($emailResult->num_rows > 0) {
        echo "Email sudah digunakan oleh pengguna lain.";
        exit();
    }

    // Update data pengguna
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, level = ?, password = ? WHERE email = ?");
        $stmt->bind_param("sssss", $username, $email, $level, $hashedPassword, $currentEmail);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, level = ? WHERE email = ?");
        $stmt->bind_param("ssss", $username, $email, $level, $currentEmail);
    }

    // Eksekusi pernyataan
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Pengguna berhasil diperbarui!'); window.location.href='manajemen-pengguna.php';</script>";
        } else {
            echo "Tidak ada perubahan yang dilakukan. Pastikan data baru berbeda dari yang lama.";
        }
    } else {
        echo "Error saat eksekusi: " . $stmt->error; // Menampilkan error
    }

    // Tutup statement
    $stmt->close();
}

// Pastikan untuk menutup koneksi setelah selesai
$conn->close();
?>
