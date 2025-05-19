<?php
// Start session and connect to database
include('../Admin/connection/connectionpro.php');
require_once '../Admin/connection/connectData.php';

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'toy-shop'); //servername, username, password, database's name

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    // Get product id and new quantity from request
    $productId = $_POST['product_id'];
    $newQuantity = $_POST['quantity'];

    // Perform necessary database update (e.g., update quantity)
    $sql = "UPDATE `order` SET o_quantity = $newQuantity WHERE p_id = $productId";
    if ($conn->query($sql) === TRUE) {
        // Database update successful
        echo "Database update successful";
    } else {
        // Database update failed
        echo "Error updating record: " . $conn->error;
    }
}
