<?php
// update-product.php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productCategory = $_POST['productCategory'];
    $productPrice = $_POST['productPrice'];
    $productStock = $_POST['productStock'];

    // Prepare the SQL statement
    $sql = "UPDATE produk SET name=?, category=?, price=?, stock=? WHERE id=?";
    
    // Initialize the prepared statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("ssiii", $productName, $productCategory, $productPrice, $productStock, $productId);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Check if a file is uploaded
        if (!empty($_FILES['file']['name'])) {
            // Handle file upload
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["file"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the file is an actual image
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if($check === false) {
                die("File is not an image.");
            }

            // Check file size (limit to 2MB)
            if ($_FILES["file"]["size"] > 2000000) {
                die("Sorry, your file is too large.");
            }

            // Allow certain file formats
            if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            }

            // Try to upload the file
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                // Update the file name in the database
                $sql = "UPDATE produk SET file=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die('Error preparing statement: ' . $conn->error);
                }
                $stmt->bind_param("si", $_FILES["file"]["name"], $productId);
                $stmt->execute();
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        }
        
        echo "Produk berhasil diperbarui.";
        header("Location: manajemen-produk.php");
        exit();
    } else {
        echo "Error updating product: " . $stmt->error;
    }
    
    $stmt->close();
}
$conn->close();
?>
