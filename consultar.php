<?php
include 'conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT turbidez, tds, temperatura, estado FROM reportes ORDER BY ID DESC LIMIT 1";
$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $estado = $row['estado'];
    $data = [
        'turbidez' => $row['turbidez'],
        'sdt' => $row['tds'],
        'temperatura' => $row['temperatura'],
        'estado' => $estado
    ];

    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se encontraron registros']);
}

$result->free();
$conn->close();
?>
