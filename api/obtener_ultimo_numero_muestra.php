<?php
header('Content-Type: application/json');

include('../includes/db_connect.php');

$response = array('success' => false);

$sql = "SELECT MAX(numero_muestra) AS ultimo_numero_muestra FROM muestras";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['numero_muestra'] = intval($row['ultimo_numero_muestra']); // Asegúrate de convertir a entero
        $response['success'] = true;
    } else {
        $response['numero_muestra'] = 0;
        $response['success'] = true;
    }
} else {
    $response['message'] = 'Error en la consulta: ' . $conn->error;
}

echo json_encode($response);

$conn->close();
?>
