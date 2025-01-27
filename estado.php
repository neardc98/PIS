<?php
include 'conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

date_default_timezone_set('America/Guayaquil');

$fecha = date('Y-m-d');
$hora = date('H:i:s');

$indicador = $_GET['indicador'];

if ($indicador === "0" || $indicador === "1") {
    $sql = "SELECT id, estado FROM reportes ORDER BY id DESC LIMIT 1;";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ultimoId = $row['id']; 

        $updateSql = "UPDATE reportes SET estado = '$indicador' WHERE id = $ultimoId;";

        if ($conn->query($updateSql) === TRUE) {
            echo "Estado del proceso actualizado correctamente";
        } else {
            echo "Error al actualizar el estado del proceso: " . $conn->error;
        }
    } else {
        echo "No se encontraron resultados en la consulta.";
    }
} else {
    $sql = "INSERT INTO reportes (Fecha, Hora, Turbidez, TDS, Temperatura, Estado) VALUES (?, ?, 0, 0, 0, 0)";

    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $fecha, $hora);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    
    $stmt->close();
}

$conn->close();
?>
