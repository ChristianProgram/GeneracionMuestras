<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    echo json_encode(array('message' => 'Método no permitido'));
    exit;
}

$nombre_muestra = $_POST['nombre_muestra'] ?? '';
$ingredientes_activos = $_POST['ingredientes_activos'] ?? '';
$formula = $_POST['formula'] ?? '';
$proveedor_id = $_POST['proveedor'] ?? '';
$token = $_POST['token'] ?? '';

if (empty($nombre_muestra) || empty($ingredientes_activos) || empty($formula) || empty($proveedor_id) || empty($token)) {
    http_response_code(400); 
    echo json_encode(array('success' => false, 'message' => 'Todos los campos son obligatorios'));
    exit;
}

if (isset($_SESSION['last_token']) && $_SESSION['last_token'] === $token) {
    http_response_code(400); 
    echo json_encode(array('success' => false, 'message' => 'La muestra ya ha sido registrada.'));
    exit;
}

$_SESSION['last_token'] = $token;

include('../includes/db_connect.php');

$nombre_muestra = $conn->real_escape_string($nombre_muestra);
$ingredientes_activos = $conn->real_escape_string($ingredientes_activos);
$formula = $conn->real_escape_string($formula);
$proveedor_id = intval($proveedor_id); 

$sql_check = "SELECT * FROM catalogo_muestras WHERE nombre_muestra = '$nombre_muestra'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo json_encode(array('success' => false, 'message' => 'La muestra ya está registrada.'));
    $conn->close();
    exit;
}

$sql_insert = "INSERT INTO catalogo_muestras (nombre_muestra, ingredientes_activos, formula, proveedor) 
               VALUES ('$nombre_muestra', '$ingredientes_activos', '$formula', '$proveedor_id')";

if ($conn->query($sql_insert) === TRUE) {
    echo json_encode(array('success' => true, 'message' => 'Muestra registrada correctamente'));
} else {
    http_response_code(500); 
    echo json_encode(array('success' => false, 'message' => 'Error al registrar la muestra: ' . $conn->error));
}

$conn->close();
?>
