<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost:3309', 'root', '', 'ecommerce');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$payment_method = isset($_POST['payment_method']) ? $conn->real_escape_string($_POST['payment_method']) : '';

if ($user_id == 0 || empty($payment_method)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID or payment method']);
    exit();
}

// Guardar el método de pago en la base de datos (modifica según tu esquema de base de datos)
$sql = "INSERT INTO user_payments (user_id, payment_method) VALUES ($user_id, '$payment_method')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Payment method saved']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save payment method', 'error' => $conn->error]);
}

$conn->close();
?>
