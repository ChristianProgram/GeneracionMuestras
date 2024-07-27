<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db_connect.php');

    $nombre_proveedor = $_POST['nombre_proveedor'];

    $sql = "INSERT INTO proveedores (nombre_proveedor) VALUES ('$nombre_proveedor')";

    if ($conn->query($sql) === TRUE) {
        echo "Proveedor registrado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
