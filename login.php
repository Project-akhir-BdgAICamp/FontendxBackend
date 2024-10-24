<?php
session_start();
require 'db_connect.php'; // Menghubungkan ke database

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query untuk mendapatkan data user berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah user ada
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Atur session untuk menandakan user sudah login
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['level'] = $user['level'];
            $_SESSION['user_id'] = $user['id']; // Simpan user_id di session

            // Redirect berdasarkan level user
            $redirectUrl = ($user['level'] === 'admin') ? 'admin-dashboard.php' : 'index.php';
            header("Location: $redirectUrl");
            exit();
        } else {
            // Password salah
            header("Location: login.php?error=Password%20salah");
            exit();
        }
    } else {
        // Username tidak ditemukan
        header("Location: login.php?error=Username%20tidak%20ditemukan");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
