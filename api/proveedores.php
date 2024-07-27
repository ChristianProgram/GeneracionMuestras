<?php
include('../includes/db_connect.php');

$sql = "SELECT id, nombre FROM proveedores";
$result = $conn->query($sql);

$proveedores = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $proveedores[] = array(
            'id' => $row['id'],
            'nombre' => $row['nombre']
        );
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($proveedores);
?>
