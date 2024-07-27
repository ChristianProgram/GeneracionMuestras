<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db_connect.php');

    $id = $_POST['id'];
    $resultado = $_POST['resultado'];
    $resultado_detalles = $_POST['resultado_detalles'];

    $sql = "UPDATE muestras SET resultado = '$resultado', resultado_detalles = '$resultado_detalles' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Resultado actualizado exitosamente.";
    } else {
        echo "Error actualizando el resultado: " . $conn->error;
    }

    $conn->close();

    header("Location: listar_muestras.php");
    exit;
} else {
    echo "Método no permitido.";
    exit;
}
?>
