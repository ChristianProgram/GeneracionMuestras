<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    echo json_encode(array('message' => 'Método no permitido'));
    exit;
}

$nombre_proveedor = $_POST['nombre_proveedor'] ?? '';
$token = $_POST['token'] ?? '';

if (empty($nombre_proveedor) || empty($token)) {
    http_response_code(400); 
    echo json_encode(array('success' => false, 'message' => 'Todos los campos son obligatorios'));
    exit;
}

if (isset($_SESSION['last_token']) && $_SESSION['last_token'] === $token) {
    http_response_code(400); 
    echo json_encode(array('success' => false, 'message' => 'El proveedor ya ha sido registrado.'));
    exit;
}

$_SESSION['last_token'] = $token;

include('../includes/db_connect.php');

$nombre_proveedor = $conn->real_escape_string($nombre_proveedor);

$sql_check = "SELECT * FROM proveedores WHERE nombre = '$nombre_proveedor'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo json_encode(array('success' => false, 'message' => 'El proveedor ya está registrado.'));
    $conn->close();
    exit;
}

$sql_insert = "INSERT INTO proveedores (nombre) VALUES ('$nombre_proveedor')";

if ($conn->query($sql_insert) === TRUE) {
    echo json_encode(array('success' => true, 'message' => 'Proveedor registrado correctamente'));
} else {
    http_response_code(500); 
    echo json_encode(array('success' => false, 'message' => 'Error al registrar el proveedor: ' . $conn->error));
}

$conn->close();
?>
