<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    include('../includes/db_connect.php');

    $sql = "SELECT * FROM muestras WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No se encontró la muestra";
        exit;
    }

    $conn->close();
} else {
    echo "ID de muestra no proporcionado";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Etiqueta de Muestra</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <style>
        @media print {
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
                width: 100%;
                display: flex;
                justify-content: flex-start;
                align-items: center;
            }
            .etiqueta {
                width: 4in;
                height: 4in;
                border: 1px solid #000;
                padding: 0.2in;
                font-size: 20px;
                text-align: left;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: flex-start;
                page-break-inside: avoid;
            }

            .etiqueta p {
                margin: 0 0 10px; 
                line-height: 1.2;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="etiqueta">
        <p><strong>Fecha de Recepción:</strong> <?php echo $row['fecha_registro']; ?></p>
        <p><strong>Nombre de la Muestra:</strong> <?php echo $row['nombre_muestra']; ?></p>
        <p><strong>Ingredientes Activos y Fórmula:</strong> <?php echo $row['ingredientes_activos'] . " / " . $row['formula']; ?></p>
        <p><strong>Lote:</strong> <?php echo $row['folio']; ?></p>
        <p><strong>Número de Muestra:</strong> <?php echo $row['numero_muestra']; ?></p>
        <p><strong>Aplicación:</strong> <?php echo $row['origen']; ?></p>
        <p><strong>Proveedor:</strong> <?php echo $row['proveedor']; ?></p>
    </div>
</body>
</html>
