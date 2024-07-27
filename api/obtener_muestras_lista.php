<?php
header('Content-Type: application/json');

include('../includes/db_connect.php');

$sql = "SELECT * FROM muestras";
$result = $conn->query($sql);

$muestras = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $muestras[] = $row;
    }
}

echo json_encode(array('success' => true, 'muestras' => $muestras));

$conn->close();
?>
