<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost:3309', 'root', '', 'ecommerce');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($user_id == 0 || $product_id == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID or product ID']);
    exit();
}

// Check if the product is already in the cart
$sql = "SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cart_item = $result->fetch_assoc();
    $new_quantity = $cart_item['quantity'] + $quantity;
    $sql = "UPDATE cart SET quantity = $new_quantity WHERE id = " . $cart_item['id'];
} else {
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart', 'error' => $conn->error]);
}

$conn->close();
?>
