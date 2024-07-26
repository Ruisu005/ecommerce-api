<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost:3309', 'root', '', 'ecommerce');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($user_id == 0 || $product_id == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID or product ID']);
    exit();
}

$sql = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Cart item removed']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to remove cart item']);
}

$conn->close();
?>
