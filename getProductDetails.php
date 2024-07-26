<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost:3309', 'root', '', 'ecommerce');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$sql = "SELECT id, name, description, price, photo FROM products WHERE id = $product_id";
$result = $conn->query($sql);

$product = null;

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
}

echo json_encode($product);

$conn->close();
?>
