<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost:3309', 'root', '', 'ecommerce');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$first_name = isset($_POST['first_name']) ? $conn->real_escape_string($_POST['first_name']) : '';
$last_name = isset($_POST['last_name']) ? $conn->real_escape_string($_POST['last_name']) : '';
$address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';
$payment_method = isset($_POST['payment_method']) ? $conn->real_escape_string($_POST['payment_method']) : '';
$card_number = isset($_POST['card_number']) ? $conn->real_escape_string($_POST['card_number']) : '';
$expiry_date = isset($_POST['expiry_date']) ? $conn->real_escape_string($_POST['expiry_date']) : '';
$cvv = isset($_POST['cvv']) ? $conn->real_escape_string($_POST['cvv']) : '';

if ($user_id == 0 || empty($first_name) || empty($last_name) || empty($address) || empty($payment_method)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID or missing required fields']);
    exit();
}

// Registrar la venta en la tabla sales
$sales_date = date('Y-m-d');
$sql = "INSERT INTO sales (user_id, pay_id, sales_date) VALUES ($user_id, '$payment_method', '$sales_date')";

// Guardar los detalles del pago (puede ser en una tabla diferente o en la misma)
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Sale and payment details recorded']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to record sale and payment details', 'error' => $conn->error]);
}

$conn->close();
?>
