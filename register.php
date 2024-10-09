<?php
ob_start(); // Memulai output buffering
session_start();
include 'db_connect.php';

// Proses registrasi ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // Perbaiki nama field
    $password = trim($_POST['password']); // Pastikan juga trim password
    $email = trim($_POST['email']);

    // Validasi apakah field tidak kosong
    if (empty($username) || empty($password) || empty($email)) {
        echo "Semua field harus diisi.";
        exit();
    }

    $level = 'user';
    if ($username === 'admin') {
        $level = 'admin';
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Menyiapkan query
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, level) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashedPassword, $email, $level);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $level;

        // Redirect berdasarkan level
        if ($level === 'admin') {
            header("Location: admin-dashboard.html");
            exit();
        } else {
            header("Location: index.html");
            exit();
        }
    } else {
        echo "Error: " . $stmt->error; // Menampilkan error jika gagal
    }

    $stmt->close(); // Menutup prepared statement
}

$conn->close(); // Menutup koneksi ke database
ob_end_flush(); // Mengirim output ke browser
?>
