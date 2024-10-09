<?php
// db_connect.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_toko";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
?>
