<?php
ob_start(); // Memulai output buffering
session_start();
include 'db_connect.php';

// Proses registrasi ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); 
    $password = trim($_POST['password']); 
    $email = trim($_POST['email']);

    // Validasi apakah field tidak kosong
    if (empty($username) || empty($password) || empty($email)) {
        echo "Semua field harus diisi.";
        exit();
    }

    // Cek apakah username sudah ada
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username sudah terdaftar. Silakan pilih username lain.";
        exit();
    }

    $level = ($username === 'admin') ? 'admin' : 'user';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Menyiapkan query
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, level) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashedPassword, $email, $level);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $level;

        // Redirect berdasarkan level
        header("Location: " . ($level === 'admin' ? 'admin-dashboard.html' : 'index.php'));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
ob_end_flush();
?>
