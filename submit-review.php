<?php
require 'db_connect.php'; // Pastikan file ini benar untuk koneksi database

if (isset($_POST['user_id'], $_POST['product_id'], $_POST['rating'], $_POST['review_text'])) {
    // Ambil data dan sanitasi input
    $user_id = htmlspecialchars($_POST['user_id']);
    $product_id = htmlspecialchars($_POST['product_id']);
    $rating = (int) $_POST['rating'];
    $review_text = htmlspecialchars($_POST['review_text']);

    // Validasi rating
    if ($rating < 1 || $rating > 5) {
        die("Rating harus antara 1 dan 5.");
    }

    // Query untuk menyimpan review
    $stmt = $conn->prepare("INSERT INTO review (user_id, product_id, rating, review_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $product_id, $rating, $review_text);

    if ($stmt->execute()) {
        echo "Review berhasil dikirim!";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Error: Semua field harus diisi.";
}

$stmt->close();
$conn->close();
?>