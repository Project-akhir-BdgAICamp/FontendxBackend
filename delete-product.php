<?php
// delete-product.php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];

    // Prepare the SQL statement
    $sql = "DELETE FROM produk WHERE id=?";
    
    // Initialize the prepared statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("i", $productId);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Produk berhasil dihapus.";
        header("Location: manajemen-produk.php");
        exit();
    } else {
        echo "Error deleting product: " . $stmt->error;
    }
    
    $stmt->close();
}
$conn->close();
?>
