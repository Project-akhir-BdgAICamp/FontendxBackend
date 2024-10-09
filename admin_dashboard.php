<?php
// admin_dashboard.php

session_start();
if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Konten khusus admin
echo "Selamat datang di Dashboard Admin!";
?>
