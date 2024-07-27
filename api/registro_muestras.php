<?php
header('Content-Type: application/json');

include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero_muestra = $_POST['numero_muestra'];
    $origen = $_POST['origen'];
    $nombre_muestra = $_POST['nombre_muestra'];
    $formula = $_POST['formula'];
    $ingredientes_activos = $_POST['ingredientes_activos'];
    $proveedor = $_POST['proveedor'];
    $fecha_caducidad = $_POST['fecha_caducidad'];
    $folio = $_POST['folio'];

    $sql = "INSERT INTO muestras (numero_muestra, origen, nombre_muestra, formula, ingredientes_activos, proveedor, fecha_caducidad, folio)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssssss', $numero_muestra, $origen, $nombre_muestra, $formula, $ingredientes_activos, $proveedor, $fecha_caducidad, $folio);

    $response = array('success' => false);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Muestra registrada exitosamente.';
    } else {
        $response['message'] = 'Error al registrar la muestra.';
    }

    echo json_encode($response);

    $stmt->close();
    $conn->close();
}
?>
