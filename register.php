<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email']) && isset($data['password']) && isset($data['firstname']) && isset($data['lastname']) && isset($data['address']) && isset($data['contact_info'])) {
    $conn = new mysqli('localhost:3309', 'root', '', 'ecommerce');
    if ($conn->connect_error) {
        die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
    }

    $email = $conn->real_escape_string($data['email']);
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    $firstname = $conn->real_escape_string($data['firstname']);
    $lastname = $conn->real_escape_string($data['lastname']);
    $address = $conn->real_escape_string($data['address']);
    $contact_info = $conn->real_escape_string($data['contact_info']);
    $type = 0;  // Tipo de Usuario, cero significa usuario cliente, y 1 significa usuario administrador
    $status = 1;  // Se asigna el estado del usuario como 1 que es activo
    $activate_code = '';
    $reset_code = '';
    $photo = 'user_default.png';  // Se asigna una foto de perfil por defecto
    $created_on = date('Y-m-d');

    $sql = "INSERT INTO users (email, password, type, firstname, lastname, address, contact_info, photo, status, activate_code, reset_code, created_on) VALUES ('$email', '$password', '$type', '$firstname', '$lastname', '$address', '$contact_info', '$photo', '$status', '$activate_code', '$reset_code', '$created_on')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
