<?php
header('Content-Type: application/json');

include('../includes/db_connect.php');

$sql = "SELECT cm.*, p.nombre AS proveedor_nombre 
        FROM catalogo_muestras cm 
        JOIN proveedores p ON cm.proveedor = p.id";
$result = $conn->query($sql);
$muestras = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $muestras[] = $row;
    }
    $response = array('success' => true, 'muestras' => $muestras);
} else {
    $response = array('success' => false, 'message' => 'Error en la consulta: ' . $conn->error);
}

echo json_encode($response);

$conn->close();
?>
